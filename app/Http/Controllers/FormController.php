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

        return view('form.block', compact('form', 'block'));
    }

    public function send(Request $request, Form $form)
    {
        $request->request->remove(['_token', 'submit']);

        $validationRules = [];
        $send_to_subscriber = NULL;

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

            if ($field->type == 'email')
            {
                $send_to_subscriber = $request->get(t($field, 'title'));
            }
        }

        if ($validationRules)
        {
            $request->validate($validationRules);
        }

        $email = Mail::to($form->send_to_email);
        if ($send_to_subscriber)
        {
            $email->cc($send_to_subscriber);
        }
        $email->send(new AppForm($form, $request));

        return redirect()->back()->with('message', t($form, 'text_website'));
    }
}
