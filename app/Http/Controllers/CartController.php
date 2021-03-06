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
        //dd(Cart::content());
        return view('webshop.cart.index');
    }

    public function store(Request $request, Product $product)
    {
        $price = $product->price;
        $option = [];


        foreach (Cart::content() as $item) {
            if ($item->id->categories[0]->season != $product->categories[0]->season) {
                return redirect()->back()->with('modal', [
                    'title' => it('cart-modal-other-season-title', 'Bestellen niet mogelijk'),
                    'content' => it('cart-modal-other-season-description', 'Dit product behoort tot een ander seizoen. Deze kunnen niet samen besteld worden.'),
                    'buttons' => '<button type="button" class="btn btn-primary" data-dismiss="modal">'. it('cart-modal-other-season-continue', 'Verder winkelen') .'</button>'
                ]);
            }
        }

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

                //$option[$variation->variation->id] = t($variation->slug, 'title', '', $variation->slug);
                $option[$variation->variation->id] = $variation->slug;
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
