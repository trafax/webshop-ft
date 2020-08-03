<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Variation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index($url_variations = null)
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

        $all_products_ids = Product::select('id')->get()->pluck('id');
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
            $products = Product::whereIn('id', $product_ids)->orderByRaw('CAST(sku as UNSIGNED) ASC')->orderBy('sku')->get();
        }
        else
        {
            $products = Product::orderByRaw('CAST(sku as UNSIGNED) ASC')->get();
        }

        return view('webshop.product.admin.index', compact('products', 'variations', 'active_variations'));
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

    public function set_variations_filter(Request $request)
    {
        $variation_arguments = [];

        if ($request->get('variations'))
        {
            foreach ($request->get('variations') as $variation => $values)
            {
                $variation_arguments[] = $variation . ':' . implode(',', $values);
            }
        }

        return redirect()->route('admin.product', [implode('/', $variation_arguments)]);
    }

    public function create()
    {
        $categories = Category::get()->toTree();
        $variations = Variation::orderBy('sort')->get();

        return view('webshop.product.admin.create', compact('categories', 'variations'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);

        $product = new Product();
        $request->request->set('price', $request->get('price') ?? 0 );
        $product->fill($request->all());
        $product->save();

        $product->categories()->attach($request->get('parent_id'));

        foreach ((array) $request->get('variations') as $variation_id => $variation)
        {
            $rows = explode("\r\n", $variation);
            foreach ($rows as $key => $row)
            {
                $option = explode(',', $row);

                $title = isset($option[0]) ? $option[0] : '';
                $fixed_price = isset($option[1]) && $option[1] > 0 ? round($option[1], 2) : 0;
                $adding_price = isset($option[2]) && $option[2] > 0 ? round($option[2], 2) : 0;

                if ($title)
                {
                    $product->variations()->attach($variation_id, [
                        'sort' => $key,
                        'title' => $title,
                        'slug' => Str::slug($title),
                        'fixed_price' => $fixed_price,
                        'adding_price' => $adding_price
                    ]);
                }
            }
        }

        return redirect()->route('admin.product.edit', $product)->with('message', 'Product succesvol toegevoegd.');
    }

    public function edit(Product $product)
    {
        $categories = Category::get()->toTree();
        $variations = Variation::orderBy('sort')->get();

        //dd($product);

        return view('webshop.product.admin.edit', compact('product', 'categories', 'variations'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['title' => 'required']);

        $product->fill($request->all());
        $product->save();

        $product->categories()->detach();
        $product->categories()->attach($request->get('parent_id'));

        if (is_array($request->get('variations')))
        {
            foreach ($request->get('variations') as $id => $variation)
            {
                $variationObj = ProductVariation::find($id);

                if (! @$variationObj->title ?? NULL) continue;

                if (empty($variation['title']))
                {
                    $variationObj->delete();
                    continue;
                }

                $variationObj->title = $variation['title'] ?? '';
                $variationObj->fixed_price = $variation['fixed_price'] ?? 0;
                $variationObj->adding_price = $variation['adding_price'] ?? 0;
                $variationObj->slug = Str::slug($variation['title']);
                $variationObj->save();
            }
        }

        // Variations
        //$product->variations()->detach();
        foreach ((array) $request->get('new_variations') as $variation_id => $variation)
        {
            $rows = explode("\r\n", $variation);
            foreach ($rows as $key => $row)
            {
                $option = explode(',', $row);

                $title = isset($option[0]) ? $option[0] : '';
                $fixed_price = isset($option[1]) ? round($option[1], 2) : 0;
                $adding_price = isset($option[2]) ? round($option[2], 2) : 0;

                if ($title)
                {
                    $productVariation = new ProductVariation();
                    $productVariation->product_id = $product->id;
                    $productVariation->variation_id = $variation_id;
                    $productVariation->title = $title;
                    $productVariation->slug = Str::slug($title);
                    $productVariation->fixed_price = $fixed_price;
                    $productVariation->adding_price = $adding_price;
                    $productVariation->save();

                    // $product->variations()->attach($variation_id, [
                    //     'sort' => $key,
                    //     'title' => $title,
                    //     'slug' => Str::slug($title),
                    //     'fixed_price' => $fixed_price,
                    //     'adding_price' => $adding_price
                    // ]);
                }
            }
        }

        return redirect()->route('admin.product.edit', $product)->with('message', 'Product succesvol aangepast.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('message', 'Product succesvol verwijderd.');
    }

    public function search(Request $request)
    {
        $products = Product::where('title', 'LIKE', '%'.$request->get('search').'%')
        ->orwhere('sku', 'LIKE', '%'.$request->get('search').'%')->get();

        return view('webshop.product.admin.index', compact('products'));
    }

    public function setViewMode(Request $request, $show)
    {
        foreach ($request->get('ids') as $id)
        {
            $product = Product::where('id', $id)->first();
            $product->visible = $show;
            $product->save();
        }

        echo 1;
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->get('ids') as $id)
        {
            $product = Product::where('id', $id)->first();
            $product->delete();
        }

        echo 1;
    }

    public function setSoldOut(Request $request, $sold_out)
    {
        foreach ($request->get('ids') as $id)
        {
            $product = Product::where('id', $id)->first();
            $product->sold_out = $sold_out;
            $product->save();
        }

        echo 1;
    }
}
