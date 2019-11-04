<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();

        return view('emailtemplate.admin.index', compact('templates'));
    }

    public function create()
    {
        return view('emailtemplate.admin.create');
    }

    public function store(Request $request)
    {
        $emailTemplate = new EmailTemplate();
        $emailTemplate->fill($request->all());
        $emailTemplate->save();

        return redirect()->route('admin.emailTemplate.index')->with('message', 'Template succesvol toegevoegd.');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('emailtemplate.admin.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $emailTemplate->fill($request->all());
        $emailTemplate->save();

        return redirect()->route('admin.emailTemplate.index')->with('message', 'Template succesvol aangepast.');
    }

    public function destroy($id)
    {
        //
    }
}
