<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class WebshopController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', NULL)->orderBy('_lft')->get()->toTree();
        $app = \app();

        // $categories[99999] = $app->make('stdClass');
        // $categories[99999]->id = 1;
        // $categories[99999]->slug = 'all';
        // $categories[99999]->encountered = 0;
        // $categories[99999]->title = it('all-products-title', 'Alle producten');
        // $categories[99999]->image = '';
        // $categories[99999]->description = '';


        return view('webshop.index', compact('categories'));
    }
}
