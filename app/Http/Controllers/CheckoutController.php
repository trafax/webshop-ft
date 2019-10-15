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

        return view('webshop.checkout.index');
    }
}
