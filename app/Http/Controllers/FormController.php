<?php

namespace App\Http\Controllers;

use App\Mail\Form as AppForm;
use App\Models\Block;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function block(Block $block)
    {
        $form = Form::find($block->block_data['form_id']);

        return view('form.form', compact('form'));
    }

    public function send(Request $request, Form $form)
    {
        $request->request->remove('_token');

        $validationRules = [];

        foreach ($form->fields as $field)
        {
            if ($field->required == 1)
            {
                if ($field->type == 'checkbox')
                {
                    $validationRules = array_merge($validationRules, [str_slug(t($field, 'title'), '_') => 'required']);
                }
                else
                {
                    $validationRules = array_merge($validationRules, [t($field, 'title') => 'required']);
                }
            }
        }

        if ($validationRules)
        {
            $request->validate($validationRules);
        }

        Mail::to('info@vanspelden.nl')->send(new AppForm($form));

    }
}
