<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::get();

        return view('form.admin.index', compact('forms'));
    }

    public function create()
    {
        return view('form.admin.create');
    }

    public function store(Request $request)
    {
        $form = new Form();
        $form->fill($request->all());
        $form->save();

        return redirect()->route('admin.form.edit', $form->id)->with('message', 'Formulier succesvol toegevoegd.');
    }

    public function edit(Form $form)
    {
        return view('form.admin.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $form->fill($request->all());
        $form->save();

        return redirect()->route('admin.form.index')->with('message', 'Formulier succesvol aangepast.');
    }

    public function destroy(Form $form)
    {
        $form->delete();

        return redirect()->route('admin.form.index')->with('message', 'Formulier succesvol verwijderd.');
    }

    public function block_edit(Block $block)
    {
        return view('form.admin.edit_block', compact('block'));
    }

    public function block_update(Block $block, Request $request)
    {
        $block->fill($request->all());
        $block->save();

        return redirect()->back();
    }
}
