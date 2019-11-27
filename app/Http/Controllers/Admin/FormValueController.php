<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormValue;
use Illuminate\Http\Request;

class FormValueController extends Controller
{
    public function create(Request $request)
    {
        return view('form.admin.value.create', compact('request'));
    }

    public function store(Request $request)
    {
        $formValue = new FormValue();
        $formValue->fill($request->all());
        $formValue->save();

        return redirect()->route('admin.form_field.edit', [$request->get('parent_id'), '#values'])->with('message', 'Waarde succesvol toegevoegd.');
    }

    public function edit(FormValue $formValue)
    {
        return view('form.admin.value.edit', compact('formValue'));
    }

    public function update(Request $request, FormValue $formValue)
    {
        $formValue->fill($request->all());
        $formValue->save();

        return redirect()->route('admin.form_field.edit', [$formValue->parent_id, '#values'])->with('message', 'Waarde succesvol aangepast.');
    }

    public function destroy(FormValue $formValue)
    {
        $formValue->delete();

        return redirect()->route('admin.form_field.edit', [$formValue->parent_id, '#values'])->with('message', 'Waarde succesvol verwijderd.');
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $formValue = FormValue::find($id);
            $formValue->sort = $key;
            $formValue->save();
        }
    }
}
