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
    public function index()
    {
        $products = Product::get();

        return view('webshop.product.admin.index', compact('products'));
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

        return redirect()->route('admin.product.index')->with('message', 'Product succesvol toegevoegd.');
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

        foreach ($request->get('variations') as $id => $variation)
        {
            $variationObj = ProductVariation::find($id);
            $variationObj->title = $variation['title'];
            $variationObj->fixed_price = $variation['fixed_price'];
            $variationObj->adding_price = $variation['adding_price'];
            $variationObj->save();

            if (empty($variation['title']))
            {
                $variationObj->delete();
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

        return redirect()->route('admin.product.index')->with('message', 'Product succesvol aangepast.');
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
}
