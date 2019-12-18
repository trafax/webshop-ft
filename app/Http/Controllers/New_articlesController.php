<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Product;
use Illuminate\Http\Request;

class New_articlesController extends Controller
{
    public function block(Block $block)
    {
        $products = Product::where('price', '>', '0')->orderBy('created_at', 'desc');

        if (isset($block->block_data['total_products']))
        {
            $products->offset(0)->limit($block->block_data['total_products']);
        }
        else
        {
            $products->offset(0)->limit(4);
        }

        $products = $products->get();

        return view('webshop.blocks.featured_articles', compact('block', 'products'));
    }
}
