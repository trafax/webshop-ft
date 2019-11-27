<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormField;
use Illuminate\Http\Request;

class FormFieldController extends Controller
{
    public function create(Request $request)
    {
        return view('form.admin.field.create', compact('request'));
    }

    public function store(Request $request)
    {
        $formField = new FormField();
        $formField->fill($request->all());
        $formField->save();

        return redirect()->route('admin.form.edit', [$request->get('parent_id'), '#fields'])->with('message', 'Veld succesvol toegevoegd.');
    }

    public function edit(FormField $formField)
    {
        return view('form.admin.field.edit', compact('formField'));
    }

    public function update(Request $request, FormField $formField)
    {
        $formField->fill($request->all());
        $formField->save();

        return redirect()->route('admin.form.edit', [$formField->parent_id, '#fields'])->with('message', 'Veld succesvol aangepast.');
    }

    public function destroy(FormField $formField)
    {
        $formField->delete();

        return redirect()->route('admin.form.edit', [$formField->parent_id, '#fields'])->with('message', 'Veld succesvol verwijderd.');
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $formField = FormField::find($id);
            $formField->sort = $key;
            $formField->save();
        }
    }
}
