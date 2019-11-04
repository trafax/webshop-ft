<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\Facade as PDF;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = new \App\Mail\Order($this->order);
        $pdf = PDF::loadHTML($data->build()->html);
        $pdf = $pdf->stream();

        $orderText = EmailTemplate::find('de158cc0-fcf1-11e9-b369-fb192d37d9d2')->content;

        $html = str_replace('##naam##', $this->order->customer->name, $orderText);

        $template_html = view('webshop.emails.invoice')->with([
            'html' => $html,
            'order' => $this->order
            ])->render();

        return $this->html($template_html)->from('bestellingen@floratuin.com')
            ->subject('Factuur '. $this->order->nr)
            ->attachData($pdf, 'Factuur '.$this->order->nr.'.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
