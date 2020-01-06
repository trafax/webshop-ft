<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->orderBy('lastname', 'ASC')->get();

        return view('customer.admin.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users'
        ]);

        $user = new User();
        $request->request->set('password', Hash::make($request->get('password')));
        $user->fill($request->all());
        $user->save();

        $user->customer()->create($request->all());

        return redirect()->route('admin.customer.index')->with('message', 'Klant succesvol toegevoegd.');
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();

        return view('customer.admin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|unique:users,email,'.$id.',id'
        ]);

        $user = User::where('id', $id)->first();
        $user->fill($request->all());
        $user->save();

        $user->customer()->updateOrCreate(['user_id' => $id], $request->all());

        return redirect()->route('admin.customer.index')->with('message', 'Klant succesvol aangepast.');
    }

    public function destroy($user_id)
    {
        $user = User::find($user_id);
        $user->delete();

        return redirect()->route('admin.customer.index')->with('message', 'Klant succesvol verwijderd.');
    }

    public function searchByProduct(Request $request)
    {
        $customers = User::where('role', 'customer')
        ->whereHas('orders', function($q) use ($request) {
            $q->whereHas('rules', function($q) use ($request) {
                $q->where('sku', 'LIKE',  '%'.$request->get('search').'%')
                ->orWhere('title', 'LIKE',  '%'.$request->get('search').'%');
            });
        })
        ->orderBy('lastname', 'ASC')->groupBy('id')->get();

        return view('customer.admin.index', compact('customers'));
    }
}
