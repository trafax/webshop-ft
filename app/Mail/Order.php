<?php

namespace App\Mail;

use App\Models\Order as AppOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Order extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AppOrder $order)
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
        return $this->from('bestellingen@floratuin.com')
                ->view('webshop.emails.order')->subject('Bestelling: '. $this->order->nr)->with('order', $this->order);
    }
}
