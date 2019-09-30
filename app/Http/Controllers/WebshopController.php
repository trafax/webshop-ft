<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class WebshopController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', NULL)->orderBy('_lft')->get()->toTree();

        return view('webshop.index', compact('categories'));
    }
}
