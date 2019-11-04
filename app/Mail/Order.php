<?php

namespace App\Mail;

use App\Models\EmailTemplate;
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
        $orderText = EmailTemplate::find('2fddb530-fcec-11e9-b393-9f27738fd848')->content;

        $html = str_replace('##naam##', $this->order->customer->name, $orderText);
        $html = str_replace('##gegevens##', view('webshop.emails.partials.order_details')->with('order', $this->order)->render(), $html);

        $template_html = view('webshop.emails.order')->with([
            'html' => $html,
            'order' => $this->order
            ])->render();

        return $this->html($template_html)
            ->subject('Bestelling '. $this->order->nr)
            ->from('bestellingen@floratuin.com');
    }
}
