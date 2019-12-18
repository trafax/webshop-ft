<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Product;
use Illuminate\Http\Request;

class Featured_articlesController extends Controller
{
    public function block(Block $block)
    {
        $products = Product::where('featured', 1);

        if (isset($block->block_data['total_products']))
        {
            $products->offset(0)->limit($block->block_data['total_products']);
        }
        else
        {
            $products->offset(0)->limit(4);
        }

        if ($block->block_data['sort_by'] == 'title')
        {
            $products->orderBy('title', 'ASC');
        }
        else
        {
            $products->inRandomOrder();
        }

        $products = $products->get();

        return view('webshop.blocks.featured_articles', compact('block', 'products'));
    }
}
