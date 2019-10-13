<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $category = last($product->categories()->get()->toArray());
        $category = (object) $category;

        $breadcrumbs = Category::whereAncestorOf($category->id)->get();

        return view('webshop.product.index', compact('product', 'category', 'breadcrumbs'));
    }
}
