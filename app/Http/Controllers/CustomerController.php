<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('customer');
    }
}
