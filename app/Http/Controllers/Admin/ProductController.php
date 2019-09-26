<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

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

        return view('webshop.product.admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->fill($request->all());
        $product->save();

        $product->categories()->attach($request->get('parent_id'));

        return redirect()->route('product.index')->with('message', 'Product succesvol toegevoegd.');
    }

    public function edit(Product $product)
    {
        $categories = Category::get()->toTree();

        return view('webshop.product.admin.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();

        $product->categories()->detach();
        $product->categories()->attach($request->get('parent_id'));

        return redirect()->route('product.index')->with('message', 'Product succesvol aangepast.');
    }

    public function destroy($id)
    {
        //
    }
}
