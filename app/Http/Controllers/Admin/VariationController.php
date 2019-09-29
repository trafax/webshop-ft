<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Variation;

class VariationController extends Controller
{
    public function index()
    {
        $variations = Variation::orderBy('sort')->get();

        return view('webshop.variation.admin.index', compact('variations'));
    }

    public function create()
    {
        return view('webshop.variation.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);

        $variation = new Variation();
        $variation->fill($request->all());
        $variation->save();

        return redirect()->route('variation.index')->with('message', 'Variatie succesvol toegevoegd.');
    }

    public function edit(Variation $variation)
    {
        return view('webshop.variation.admin.edit', compact('variation'));
    }

    public function update(Request $request, Variation $variation)
    {
        $request->validate(['title' => 'required']);

        $variation->fill($request->all());
        $variation->save();

        return redirect()->route('variation.index')->with('message', 'Variatie succesvol aangepast.');
    }

    public function destroy(Variation $variation)
    {
        $variation->delete();

        return redirect()->back()->with('message', 'Variatie succesvol verwijderd.');
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $variation = Variation::find($id);
            $variation->sort = $key;
            $variation->save();
        }
    }
}
