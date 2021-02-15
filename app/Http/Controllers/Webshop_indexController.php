<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Category;
use Illuminate\Http\Request;

class Webshop_indexController extends Controller
{
    public function block(Block $block)
    {
        $categories = Category::where('visible', 1)->where('featured', 1)->orderBy('_lft')->get();

        return view('webshop.blocks.webshop_index', compact('block', 'categories'));
    }
}
