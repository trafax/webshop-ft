<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WebshopController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', NULL)->where('visible', 1)->orderBy('_lft')->get()->toTree();
        $app = \app();

        // $categories[99999] = $app->make('stdClass');
        // $categories[99999]->id = 1;
        // $categories[99999]->slug = 'all';
        // $categories[99999]->encountered = 0;
        // $categories[99999]->title = it('all-products-title', 'Alle producten');
        // $categories[99999]->image = '';
        // $categories[99999]->description = '';

        $blocks = Block::where('parent_id', 'webshop')->orderBy('sort')->get();

        return view('webshop.index')->with([
            'categories' => $categories,
            'blocks' => $blocks
        ]);
    }

    public function products_feed()
    {
        $products = Product::where('visible', 1)->where('sold_out', 0)->get();

        //return view('webshop.feed');
        return response()->view('webshop.feed', compact('products'))->withHeaders([
            'Content-Type' => 'text/xml'
        ]);
    }
}
