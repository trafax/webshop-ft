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
        $product = Product::where('slug', $slug)->firstOrFail();

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
}
