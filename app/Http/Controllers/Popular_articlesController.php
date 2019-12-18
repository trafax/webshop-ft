<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Popular_articlesController extends Controller
{
    public function block(Block $block)
    {
        $products = DB::table('order_rules')->selectRaw('*, sum(qty) as sum')->groupBy('product_id')->orderBy('sum', 'desc');

        if (isset($block->block_data['total_products']))
        {
            $products->offset(0)->limit($block->block_data['total_products']);
        }
        else
        {
            $products->offset(0)->limit(4);
        }

        $products = $products->get();

        if ($products) {
            $products = Product::whereIn('id', $products->pluck('product_id')->toArray())->get();
        }

        return view('webshop.blocks.featured_articles', compact('block', 'products'));
    }
}
