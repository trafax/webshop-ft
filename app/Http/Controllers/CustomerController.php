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

    public function edit()
    {
        $user = Auth::user();

        return view('customer.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'street' => 'required',
            'number' => 'required',
            'zipcode' => 'required',
            'telephone' => 'nullable|digits:10',
            'city' => 'required',
            'language_key' => 'required',
            'email' => 'required|unique:users,email,'.$user->id.',id',
            'delivery_street' => 'required_if:other_delivery,1',
            'delivery_number' => 'required_if:other_delivery,1',
            'delivery_zipcode' => 'required_if:other_delivery,1',
            'delivery_city' => 'required_if:other_delivery,1'
        ]);

        $user->fill($request->all());
        $user->customer()->updateOrCreate(['user_id' => $user->id], $request->all());
        $user->save();

        return redirect()->route('customer.edit')->with('message', 'Uw gegevens zijn succesvol aangepast.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('customer');
    }
}
