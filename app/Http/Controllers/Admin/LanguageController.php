<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::orderBy('sort')->get();

        return view('language.admin.index', compact('languages'));
    }

    public function create()
    {
        return view('language.admin.create');
    }

    public function store(Request $request)
    {
        $language = new Language();
        $language->fill($request->all());
        $language->save();

        return redirect()->route('admin.language.index')->with('message', 'Taal succesvol toegevoegd.');
    }

    public function edit(Language $language)
    {
        return view('language.admin.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $language->fill($request->all());
        $language->save();

        return redirect()->route('admin.language.index')->with('message', 'Taal succesvol aangepast.');
    }

    public function destroy(Language $language)
    {
        $language->delete();

        return redirect()->back()->with('message', 'Taal succesvol verwijderd.');
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $language = Language::find($id);
            $language->sort = $key;
            $language->save();
        }
    }
}
