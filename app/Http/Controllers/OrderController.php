<?php

namespace App\Http\Controllers;

use App\Mail\Order as AppOrder;
use App\Models\Order;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::whereHas('customer', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->orderBy('created_at', 'DESC')->orderBy('nr', 'DESC')->get();

        // Get other orders
        $other_orders = Order::on('mysql_other')->whereHas('customer', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->orderBy('created_at', 'DESC')->orderBy('nr', 'DESC')->get();

        $orders = $orders->merge($other_orders);

        return view('webshop.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('id', $id)->whereHas('customer', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->first();

		if (! $order) {
            $order = Order::on('mysql_other')->where('id', $id)->whereHas('customer', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->firstOrFail();
        }

        return view('webshop.orders.show', compact('order'));
    }

    public function download_invoice($id)
    {
        $order = Order::where('id', $id)->whereHas('customer', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->first();

		if (! $order) {
			$order = Order::on('mysql_other')->where('id', $id)->whereHas('customer', function ($query) {
				$query->where('user_id', Auth::user()->id);
			})->firstOrFail();
		}

        $data = new AppOrder($order);
        $pdf = PDF::loadHTML($data->build()->html);
        return $pdf->download('Factuur '. $order->nr . '.pdf');
    }
}
