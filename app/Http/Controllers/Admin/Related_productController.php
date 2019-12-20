<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RelatedProduct;
use Illuminate\Http\Request;

class Related_productController extends Controller
{
    public function insert(Request $request)
    {
        // Te koppelen product
        $product = Product::where('sku', $request->get('sku'))->first();

        if ($product)
        {
            RelatedProduct::create([
                'id' => $request->get('id'),
                'parent_id' => $product->id
            ]);

            RelatedProduct::create([
                'parent_id' => $request->get('id'),
                'id' => $product->id
            ]);

            echo 1;
        }
    }

    public function delete(Request $request)
    {
        RelatedProduct::where(['id' => $request->get('id'), 'parent_id' => $request->get('parent_id')])->delete();
        RelatedProduct::where(['parent_id' => $request->get('id'), 'id' => $request->get('parent_id')])->delete();

        echo 1;
    }
}
