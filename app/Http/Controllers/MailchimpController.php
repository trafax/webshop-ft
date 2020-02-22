<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Newsletter;

class MailchimpController extends Controller
{
    public function block($block)
    {
        return view('mailchimp.block', compact('block'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
        ]);

        if (Newsletter::isSubscribed($request->get('email')) == false) {
            Newsletter::subscribe($request->get('email'), ['FNAME' => $request->get('fname'), 'LNAME' => $request->get('lname')]);
            Session::flash('message', it('newsletter-success', 'U bent succesvol ingeschreven.'));
        } else {
            Session::flash('message', it('newsletter-not-success', 'U bent al ingeschreven.'));
        }

        return redirect()->to(url()->previous() . '#mailchimp');
    }
}
