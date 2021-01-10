<?php

namespace App\Http\Controllers;

use App\Models\Block;

class Webshop_searchController extends Controller
{
    public function block(Block $block)
    {
        return view('webshop.blocks.search', compact('block'));
    }
}
