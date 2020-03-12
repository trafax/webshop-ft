<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Gloudemans\Shoppingcart\Facades\Cart as Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('webshop.cart.index');
    }

    public function store(Request $request, Product $product)
    {
        $price = $product->price;
        $option = [];

        session()->forget('order_id');

        if (is_array($request->get('options')))
        {
            foreach ($request->get('options') as $option_slug)
            {
                $variation = ProductVariation::where(['product_id' => $product->id, 'slug' => $option_slug])->first();

                if ($variation->fixed_price > 0)
                {
                    $price = $variation->fixed_price;
                }
                if ($variation->adding_price > 0)
                {
                    $price = $price + $variation->adding_price;
                }

                $option[$variation->variation->id] = t($variation->slug, 'title', '', $variation->title);
            }
        }

        Cart::add($product, t($product, 'title'), $request->get('qty'), $price, $option);

        return redirect()->back()->with('modal', [
            'title' => it('cart-modal-title', 'Winkelwagen'),
            'content' => it('cart-modal-description', 'Het artikel is succesvol toegevoegd in de winkelwagen.'),
            'buttons' => '<button type="button" class="btn btn-primary" data-dismiss="modal">'. it('cart-modal-continue', 'Verder winkelen') .'</button>
            <a class="btn btn-green" href="'.route('cart').'">'. it('cart-modal-pay', 'Afrekenen') .'</a>'
            ]);
    }

    public function update()
    {

    }

    public function delete($row_id)
    {
        Cart::remove($row_id);

        session()->forget('order_id');

        return redirect()->back();
    }
}
