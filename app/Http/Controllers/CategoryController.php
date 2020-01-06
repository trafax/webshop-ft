<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Variation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
public function index(Request $request, $slug, $url_variations = null)
{
    // Read variations out of URL
    $active_variations = [];
    $url_variations_explode = explode('/', $url_variations);
    if ($url_variations_explode)
    foreach ($url_variations_explode as $url_variation)
    {
        if ($url_variation)
        {
            $row_url_variation = explode(':', $url_variation);
            $active_variations[$row_url_variation[0]] = $row_url_variation[1];
        }
    }

    $category = Category::where('slug', $slug)->firstOrFail();

    $variations = [];
    $all_products_ids = $category->products()->select('id')->get()->pluck('id');
    $all_variation_ids = ProductVariation::select('variation_id')->whereIn('product_id', $all_products_ids)->groupBy('variation_id')->get()->pluck('variation_id');
    $variations_tmp = Variation::orderBy('sort')->findMany($all_variation_ids);

    foreach ($variations_tmp as $variation)
    {
        $values = ProductVariation::where('variation_id', $variation->id)->whereIn('product_id', $all_products_ids)->groupBy('title');

        if ($variation->sort_by == 'number_in_string') {
            $values = $values->orderByRaw('CAST(title as UNSIGNED) ASC');
        }
        else if ($variation->sort_by == 'title') {
            $values = $values->orderBy('title');
        }
        else if ($variation->sort_by == 'price') {
            $values = $values->orderBy('fixed_price')->orderBy('adding_price');
        }
        $values = $values->get(['id', 'title', 'slug']);
        $variation->values = $values;
        $variations[] = $variation;
    }

    // Select filtered products
    $product_ids = $this->filter_products([
        'product_ids' => $all_products_ids,
        'variations' => $url_variations
    ]);

    if ($url_variations)
    {
        $products = Product::whereIn('id', $product_ids)->orderBy('price')->orderBy('title')->paginate(setting('products_pp'));
    }
    else
    {
        $products = $category->products()->paginate(setting('products_pp'));
    }

    $breadcrumbs = Category::whereAncestorOf($category)->get();

    $seo = [
        'title' => t($category, 'seo[title]') ? t($category, 'seo[title]') : t($category, 'title'),
        'keywords' => t($category, 'seo[keywords]'),
        'description' => t($category, 'seo[description]')
    ];

    return view('webshop.category.index', compact('category', 'products', 'breadcrumbs', 'variations', 'active_variations', 'seo'));
}

    public function filter_products($variations = [])
    {
        $product_ids = [];

        $variation_slugs = [];
        if (isset($variations['product_ids']) && isset($variations['variations']))
        {
            $explode = explode('/', $variations['variations']);
            foreach ($explode as $variation_exploded)
            {
                $variation_slugs = explode(',', last(explode(':', $variation_exploded)));
                $ids = ProductVariation::slugs($variation_slugs)->get();
                $product_ids[] = $ids->toArray();
            }

            $temp_ids = [];
            foreach ($explode as $key => $variation_exploded)
            {
                foreach ($variations['product_ids'] as $product_id)
                {
                    $count_value = array_count_values(array_column($product_ids[$key], 'product_id'));
                    if (isset($count_value[$product_id]) && $count_value[$product_id] > 0)
                    {
                        $temp_ids[] = $product_id;
                    }
                }
            }

            $product_ids = [];
            foreach ($variations['product_ids'] as $product_id)
            {
                $count_value = array_count_values($temp_ids);
                if (isset($count_value[$product_id]) && $count_value[$product_id] >= count($explode))
                {
                    $product_ids[] = $product_id;
                }
            }

            return $product_ids;
        }
    }

    public function set_variations_filter(Request $request, $slug)
    {
        $variation_arguments = [];

        if ($request->get('variations'))
        {
            foreach ($request->get('variations') as $variation => $values)
            {
                $variation_arguments[] = $variation . ':' . implode(',', $values);
            }
        }

        return redirect()->route('category', [$slug, implode('/', $variation_arguments)]);
    }

    public function all($url_variations = null)
    {
        $active_variations = [];
        $url_variations_explode = explode('/', $url_variations);
        if ($url_variations_explode)
        foreach ($url_variations_explode as $url_variation)
        {
            if ($url_variation)
            {
                $row_url_variation = explode(':', $url_variation);
                $active_variations[$row_url_variation[0]] = $row_url_variation[1];
            }
        }

        $all_products_ids = Product::select('id')->where('visible', 1)->get()->pluck('id');
        $all_variation_ids = ProductVariation::select('variation_id')->whereIn('product_id', $all_products_ids)->groupBy('variation_id')->get()->pluck('variation_id');
        $variations_tmp = Variation::orderBy('sort')->findMany($all_variation_ids);
        $variations = [];

        foreach ($variations_tmp as $variation)
        {
            $values = ProductVariation::where('variation_id', $variation->id)->whereIn('product_id', $all_products_ids)->groupBy('title');
            if ($variation->sort_by == 'number_in_string') {
                $values = $values->orderByRaw('CAST(title as UNSIGNED) ASC');
            }
            else if ($variation->sort_by == 'title') {
                $values = $values->orderBy('title');
            }
            else if ($variation->sort_by == 'price') {
                $values = $values->orderBy('fixed_price')->orderBy('adding_price');
            }
            $values = $values->get(['id', 'title', 'slug']);
            $variation->values = $values;
            $variations[] = $variation;
        }

        // Select filtered products
        $product_ids = $this->filter_products([
            'product_ids' => $all_products_ids,
            'variations' => $url_variations
        ]);

        if ($url_variations)
        {
            $products = Product::whereIn('id', $product_ids)->orderBy('price')->orderBy('title')->paginate(setting('products_pp'));
        }
        else
        {
            $products = Product::where('visible', 1)->paginate(setting('products_pp'));
        }

        // $seo = [
        //     'title' => t($category, 'seo[title]') ? t($category, 'seo[title]') : t($category, 'title'),
        //     'keywords' => t($category, 'seo[keywords]'),
        //     'description' => t($category, 'seo[description]')
        // ];

        $category = new Category();
        $category->slug = 'all';
        $category->title = 'Alle producten';
        $breadcrumbs = [];

        return view('webshop.category.index', compact('category', 'products', 'breadcrumbs', 'variations', 'active_variations', 'seo'));
    }
}
