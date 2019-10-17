<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('title', 'ASC')->get();

        return view('country.admin.index', compact('countries'));
    }

    public function create()
    {
        return view('country.admin.create');
    }

    public function store(Request $request)
    {
        $country = new Country();
        $country->fill($request->all());
        $country->save();

        return redirect()->route('admin.country.index')->with('message', 'Land succesvol toegevoegd.');
    }

    public function edit(Country $country)
    {
        return view('country.admin.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $country->fill($request->all());
        $country->save();

        return redirect()->route('admin.country.index')->with('message', 'Land succesvol aangepast.');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->route('admin.country.index')->with('message', 'Land succesvol verwijderd.');
    }
}
