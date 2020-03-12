<?php

namespace App\Mail;

use App\Models\Form as AppForm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Form extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AppForm $form, Request $request)
    {
        $this->form = $form;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('form.email.form')->with([
            'form' => $this->form,
            'request' => $this->request
        ])->subject(t($this->form, 'title'))->from('info@floratuin.com', 'Floratuin Julianadorp');
    }
}
