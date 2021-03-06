<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($slug)
    {
        $product = Product::where('slug', $slug)->where('visible', 1)->firstOrFail();

        $category = last($product->categories()->get()->toArray());
        $category = (object) $category;

        if (! isset($category->id)) $category = new Category();

        $breadcrumbs = Category::whereAncestorOf($category->id)->get();
        $variations = Variation::where('selectable', 1)->orderBy('sort')->get();

        $seo = [
            'title' => t($product, 'seo[title]') ? t($product, 'seo[title]') : t($product, 'title'),
            'keywords' => t($product, 'seo[keywords]'),
            'description' => t($product, 'seo[description]')
        ];

        return view('webshop.product.index', compact('product', 'category', 'breadcrumbs', 'variations', 'seo'));
    }

    public function search(Request $request)
    {
        $products = Product::where('visible', 1)->where('title', 'LIKE', '%'.$request->get('search').'%')
        ->orwhere('sku', 'LIKE', '%'.$request->get('search').'%')->paginate(setting('products_pp'));

        return view('webshop.product.search', compact('products', 'request'));
    }
}
