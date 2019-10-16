<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (! Auth::user())
        {
            return redirect()->route('customer');
        }

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(env('MOLLIE_API_KEY'));
        $payment_methods = $mollie->methods->all();

        return view('webshop.checkout.index', compact('payment_methods'));
    }

    public function place_order(Request $request)
    {
        dump($request->all());
    }
}
