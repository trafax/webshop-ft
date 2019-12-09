<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Translation;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImportController extends Controller
{
    public function index()
    {
        self::import_categories();

        self::import_products();

        self::import_variations();

        self::import_images();
    }

    public function import_categories()
    {
        //Category::truncate();

        $categories = \DB::connection('remote')->select("SELECT * FROM webshop_categories WHERE deleted = 0");
        foreach ($categories as $category)
        {
            $categoryNew = Category::firstOrCreate([
                'title' => $category->title
            ], [
                'old_id' => $category->uuid,
                'title' => $category,
                'slug' => $category->slug,
                'description' => $category->description,
                'seo' => [
                    'title' => $category->title,
                    'keywords' => $category->seo_keywords,
                    'description' => $category->seo_description,
                ]
            ]);

            $oldImage = \DB::connection('remote')->select("SELECT * FROM webshop_categories_files WHERE deleted = 0 AND uuid_parent = '{$categoryNew->old_id}'");
            if ($oldImage[0]->file)
            {
                $url = "https://floratuin.com/uploads/webshop/categories/". $oldImage[0]->file;

                $file_data = file_get_contents( $url, false, stream_context_create( [
                    'ssl' => [
                        'verify_peer'      => false,
                        'verify_peer_name' => false,
                    ],
                ] ) );

                if ($file_data) {

                    $img = Image::make($url);

                    $filename =  basename($url);
                    //$img->save(storage_path("app\public\assets\\") . $filename);
                    $img->save(public_path("\photos\categorieen\\") . $filename);

                    $data = array_merge(['parent_id' => $categoryNew->id], ['file' => 'assets/'. $filename]);

                    //Asset::firstOrCreate($data);
                    $categoryNew->image = '/photos/categorieen/'. $filename;
                    $categoryNew->save();
                }
            }

            $translations = \DB::connection('remote')->select("SELECT * FROM translations WHERE uuid_object = '{$categoryNew->old_id}'");

            foreach ($translations as $translation)
            {
                $language = \DB::connection('remote')->select("SELECT * FROM languages WHERE uuid = '{$translation->uuid_language}'");

                $field = str_replace(['seo_title','seo_keywords','seo_description'], ['seo[title]','seo[keywords]','seo[description]'], $translation->field);

                Translation::firstOrCreate([
                    'parent_id' => $categoryNew->id,
                    'language_key' => $language[0]->key,
                    'field' => $field,
                    'value' => strip_tags($translation->value)
                ]);
            }
        }
    }

    public function import_products()
    {
        //Product::truncate();

        $old_products = \DB::connection('remote')->select("SELECT * FROM webshop_products WHERE deleted = 0");
        foreach ($old_products as $old_product)
        {
            $product = Product::firstOrCreate([
                'sku' => $old_product->sku,
                'title' => $old_product->title,
                'description' => $old_product->description,
                'specs' => $old_product->specs,
                'price' => $old_product->price,
                'seo' => [
                    'title' => $old_product->title,
                    'keywords' => $old_product->seo_keywords,
                    'description' => $old_product->seo_description
                ],
                'visible' => $old_product->visible,
                'old_id' => $old_product->uuid
            ]);

            $old_linked_categories = \DB::connection('remote')->select("SELECT * FROM webshop_categories_linked WHERE uuid_product = '{$product->old_id}'");

            $category_ids = [];
            foreach ($old_linked_categories as $old_linked_category)
            {
                $category = Category::where('old_id', $old_linked_category->uuid_category)->first();

                $category_ids[] = $category->id;
            }

            $product->categories()->attach($category_ids);

            $translations = \DB::connection('remote')->select("SELECT * FROM translations WHERE uuid_object = '{$product->old_id}'");

            foreach ($translations as $translation)
            {
                $language = \DB::connection('remote')->select("SELECT * FROM languages WHERE uuid = '{$translation->uuid_language}'");

                $field = str_replace(['seo_title','seo_keywords','seo_description'], ['seo[title]','seo[keywords]','seo[description]'], $translation->field);

                Translation::firstOrCreate([
                    'parent_id' => $product->id,
                    'language_key' => $language[0]->key,
                    'field' => $field,
                    'value' => strip_tags($translation->value)
                ]);
            }
        }
    }

    public function import_variations()
    {
        $old_variations = \DB::connection('remote')->select("SELECT * FROM webshop_filters");

        foreach ($old_variations as $old_variation)
        {
            $variation = Variation::firstOrCreate([
                'title' => $old_variation->title,
                'sort' => $old_variation->sort,
                'old_id' => $old_variation->uuid
            ]);

            $translations = \DB::connection('remote')->select("SELECT * FROM translations WHERE uuid_object = '{$variation->old_id}'");

            foreach ($translations as $translation)
            {
                $language = \DB::connection('remote')->select("SELECT * FROM languages WHERE uuid = '{$translation->uuid_language}'");

                $field = str_replace(['seo_title','seo_keywords','seo_description'], ['seo[title]','seo[keywords]','seo[description]'], $translation->field);

                Translation::firstOrCreate([
                    'parent_id' => $variation->id,
                    'language_key' => $language[0]->key,
                    'field' => $field,
                    'value' => strip_tags($translation->value)
                ]);
            }
        }

        $old_variation_linked = \DB::connection('remote')->select("SELECT * FROM webshop_filters_linked ORDER BY price_fixed");
        foreach ($old_variation_linked as $key => $old_variation_link)
        {
            $old_variation_option = \DB::connection('remote')->select("SELECT * FROM webshop_filters_options WHERE uuid = '{$old_variation_link->uuid_option}'");
            $variation = Variation::where('old_id', $old_variation_option[0]->uuid_parent)->first();
            $product = Product::where('old_id', $old_variation_link->uuid_product)->first();

            ProductVariation::firstOrCreate([
                'product_id' => $product->id,
                'variation_id' => $variation->id,
                'title' => $old_variation_option[0]->title,
                'fixed_price' => $old_variation_link->price_fixed,
                'adding_price' => $old_variation_link->price,
                'slug' => Str::slug($old_variation_option[0]->title),
                'sort' => $key
            ]);
        }
    }

    public function import_images()
    {
        $old_images = \DB::connection('remote')->select("SELECT * FROM webshop_products_files WHERE deleted = 0 ORDER BY sort, id");

        foreach ($old_images as $old_image)
        {
            $product = Product::where('old_id', $old_image->uuid_parent)->first();

            if (! isset($product->id)) continue;

            $url = "https://floratuin.com/uploads/webshop/products/". $old_image->file;

            $file_data = file_get_contents( $url, false, stream_context_create( [
                'ssl' => [
                    'verify_peer'      => false,
                    'verify_peer_name' => false,
                ],
            ] ) );

            if ($file_data) {

                $img = Image::make($url);

                $filename =  basename($url);
                $img->save(storage_path("app\public\assets\\") . $filename);

                $data = array_merge(['parent_id' => $product->id], ['file' => 'assets/'. $filename]);

                Asset::firstOrCreate($data);
            }
        }
    }
}
