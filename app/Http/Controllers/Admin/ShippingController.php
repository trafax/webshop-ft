<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Shipping;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shipping::get();

        return view('webshop.shipping.admin.index', compact('shippings'));
    }

    public function create()
    {
        return view('webshop.shipping.admin.create');
    }

    public function store(Request $request)
    {
        $shipping = new Shipping();
        $shipping->fill($request->all());
        $shipping->save();

        return redirect()->route('admin.shipping.index')->with('message', 'Verzendkosten succesvol toegevoegd.');
    }

    public function edit(Shipping $shipping)
    {
        return view('webshop.shipping.admin.edit', compact('shipping'));
    }

    public function update(Request $request, Shipping $shipping)
    {
        $shipping->fill($request->all());
        $shipping->save();

        return redirect()->route('admin.shipping.index')->with('message', 'Verzendkosten succesvol aangepast.');
    }

    public function destroy(Shipping $shipping)
    {
        $shipping->delete();

        return redirect()->route('admin.shipping.index')->with('message', 'Verzendkosten succesvol verwijderd.');
    }
}
