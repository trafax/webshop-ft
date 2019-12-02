<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Order as AppOrder;
use App\Models\Order;
use Barryvdh\DomPDF\Facade as PDF;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->orderBy('nr', 'DESC')->paginate(25);
        return view('webshop.orders.admin.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('webshop.orders.admin.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.order.index')->with('message', 'Bestelling succesvol verwijderd.');
    }

    public function download_invoice(Order $order)
    {
        $data = new AppOrder($order);
        $pdf = PDF::loadHTML($data->build()->html);
        return $pdf->download('Factuur '. $order->nr . '.pdf');
    }

    public function update(Request $request, Order $order)
    {
        $order->order_status = $request->get('order_status');
        $order->save();

        return redirect()->route('admin.order.index')->with('message', 'Status succesvol aangepast.');
    }
}
