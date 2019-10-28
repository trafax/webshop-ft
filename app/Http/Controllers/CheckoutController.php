<?php

namespace App\Http\Controllers;

use App\Libraries\Cart as AppCart;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\OrderRule;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (! Auth::user())
        {
            return redirect()->route('customer');
        }

        if (Cart::count() == 0)
        {
            return redirect()->route('webshop');
        }

        if (! Auth::user()->customer->street)
        {
            return redirect()->route('customer.edit')->with('error', 'U heeft nog niet alle gegevens ingevoerd.');
        }

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(env('MOLLIE_API_KEY'));
        $payment_methods = $mollie->methods->all();

        return view('webshop.checkout.index', compact('payment_methods'));
    }

    public function place_order(Request $request)
    {
        $request->validate([
            'agreed' => 'required'
        ]);

        if (! $request->session()->get('order_id'))
        {
            $order_nr = (int) Order::orderBy('created_at', 'DESC')->pluck('nr')->first() + 1;

            // Bestelling opslaan
            $order = new Order();
            $order->nr = $order_nr;
            $order->sub_total = AppCart::subtotal(2, '.');
            $order->tax = AppCart::tax(2, '.');
            $order->shipping = AppCart::shipping(2, '.');
            $order->total = AppCart::total(2, '.');
            $order->payment_method = $request->get('payment_method');
            $order->save();

            // Artikelen van bestelling opslaan
            foreach (Cart::content() as $item)
            {
                $order->rules()->attach($order->id, [
                    'product_id' => $item->id->id,
                    'sku' => $item->id->sku,
                    'title' => t($item->id, 'title'),
                    'qty' => $item->qty,
                    'options' => $item->options,
                    'price' => $item->total
                ]);
            }

            // Customer gegevens opslaan
            $order->customer()->create(array_merge(
                ['order_id' => $order->id],
                Auth::user()->toArray(),
                Auth::user()->customer->toArray()
            ));

            $request->session()->put('order_id', $order_nr);
        }
        else
        {
            $order = Order::where('nr', session('order_id'))->first();
        }

        // Betaling starten
        return $this->start_payment($order, $request->get('payment_method'));
    }

    public function start_payment(Order $order, $payment_method)
    {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(env('MOLLIE_API_KEY'));

        // Betaling starten
        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $order->total
            ],
            "description" => 'Bestelling ' . $order->nr,
            "redirectUrl" => route('checkout.return_payment', $order->id),
            "webhookUrl"  => route('checkout.webhook_payment'),
            "method"      => $payment_method,
            "metadata" => [
                "id" => $order->id,
            ],
        ]);

        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function webhook_payment(Request $request)
    {
        // Order status ophalen
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(env('MOLLIE_API_KEY'));
        $payment = $mollie->payments->get($request->get('id'));

        // Order status opslaan
        $order = Order::findOrFail($payment->metadata->id);
        $order->status = $payment->status;
        $order->save();
    }

    public function return_payment(Order $order)
    {
        switch($order->status)
        {
            case 'paid':
                Cart::destroy();
                session()->forget('order_id');
                return view('webshop.payments.success');
                break;

            case 'error':
            case 'failed':
            case 'canceled':
            case 'expired':
            case 'open':
            case 'pending':
            default:
                return view('webshop.payments.error');
                break;
        }
    }
}
