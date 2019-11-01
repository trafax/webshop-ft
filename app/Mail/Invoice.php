<?php

namespace App\Mail;

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
        $pdf = PDF::loadView('webshop.emails.order', ['order' => $this->order]);
        $pdf = $pdf->stream();

        return $this->from('bestellingen@floratuin.com')
            ->attachData($pdf, 'Factuur'.$this->order->nr.'.pdf', [
                'mime' => 'application/pdf',
            ])
            ->view('webshop.emails.invoice')->subject('Betaling voltooid')->with('order', $this->order);
    }
}
