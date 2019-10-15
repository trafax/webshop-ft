<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart as Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        //Cart::destroy();
        $items = Cart::content();

        //dd($items);

        return view('webshop.cart.index', compact('items'));
    }

    public function store(Request $request, Product $product)
    {
        Cart::add($product, t($product, 'title'), $request->get('qty'), $product->price);

        return redirect()->back()->with('modal', [
            'title' => 'Winkelwagen',
            'content' => 'Het artikel is succesvol toegevoegd in de winkelwagen.',
            'buttons' => '<button type="button" class="btn btn-primary" data-dismiss="modal">Verder winkelen</button>
            <a class="btn btn-green" href="'.route('cart').'">Afrekenen</a>'
            ]);
    }

    public function update()
    {

    }

    public function delete($row_id)
    {
        Cart::remove($row_id);

        return redirect()->back();
    }
}
