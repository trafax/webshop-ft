<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Order as AppOrder;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\OrderRule;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ShippingRule;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function create()
    {
        return view('webshop.orders.admin.create');
    }

    public function store(Request $request)
    {
        $order_nr = (int) Order::orderBy('created_at', 'DESC')->pluck('nr')->first() + 1;

        if ($request->get('id_user'))
        {
            $user = User::find($request->get('id_user'));
        }
        else
        {
            $request->validate([
                'email' => 'unique:users,email'
            ]);

            $user = new User();
            $request->request->set('password', Hash::make(Str::random(8)));
            $user->fill($request->all());
            $user->save();

            $user->customer()->create($request->all());
        }

        $language_key = $user->customer->other_delivery == 1 ? $user->customer->delivery_language_key : $user->customer->language_key;
        $country = Country::where('language_key', $language_key)->first();

        if ($country)
        {
            $shippingRule = ShippingRule::where('country_id', $country->id)->first();

            if ($shippingRule)
            {
                $shipping = $shippingRule->price;
            }
        }

        $order = new Order();
        $order->nr = $order_nr;
        $order->shipping = $shipping;
        $order->save();

        OrderCustomer::create(array_merge(
            ['order_id' => $order->id],
            $user->toArray(),
            $user->customer->toArray()
        ));

        return redirect()->route('admin.order.show', $order);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.order.index')->with('message', 'Bestelling succesvol verwijderd.');
    }

    public function add_invoice_rule(Request $request)
    {
        return view('webshop.orders.admin.add_invoice_rule', compact('request'));
    }

    public function store_invoice_rule(Order $order, Request $request)
    {
        $product = Product::where('sku', $request->get('sku'))->first();

        if ($product)
        {
            OrderRule::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'sku' => $product->sku,
                'title' => $product->title,
                'qty' => 1,
                'options' => '',
                'price' => $product->price
            ]);
        }

        $sub_total = 0;
        foreach (OrderRule::where('order_id', $order->id)->get() as $order_rule)
        {
            $sub_total += $order_rule->price;
        }

        $order->sub_total = $sub_total;
        $order->tax = ($sub_total * 1.09) - $sub_total;
        $order->total = $sub_total + $order->shipping;
        $order->save();

        return redirect()->route('admin.order.show', $order);
    }

    public function download_invoice(Order $order)
    {
        $data = new AppOrder($order);
        $pdf = PDF::loadHTML($data->build()->html);
        return $pdf->download('Factuur '. $order->nr . '.pdf');
    }

    public function update(Request $request, Order $order)
    {
        $order->fill($request->all());

        foreach ($request->get('rule') as $id => $rule)
        {
            $orderRule = OrderRule::find($id);
            $product = Product::find($orderRule->product_id);

            $price = $product->price;
            if (isset($rule['options']))
            {
                foreach ($rule['options'] as $option_id => $option)
                {
                    $variation = ProductVariation::where(['product_id' => $product->id, 'slug' => $option])->first();

                    if ($variation->fixed_price > 0)
                    {
                        $price = $variation->fixed_price;
                    }
                    if ($variation->adding_price > 0)
                    {
                        $price = $price + $variation->adding_price;
                    }
                }
            }

            $orderRule->qty = $rule['qty'];
            $orderRule->options = isset($rule['options']) ? $rule['options'] : [];
            $orderRule->price = $price * $rule['qty'];
            $orderRule->save();

            $this->update_order_price($order);
        }

        return redirect()->route('admin.order.index')->with('message', 'Status succesvol aangepast.');
    }

    public function delete_row(OrderRule $orderRule)
    {
        $order = $orderRule->order;
        $orderRule->delete();

        $this->update_order_price($order);

        return redirect()->back();
    }

    public function update_order_price(Order $order)
    {
        $sub_total = 0;
        foreach (OrderRule::where('order_id', $order->id)->get() as $order_rule)
        {
            $sub_total += $order_rule->price;
        }

        $order->sub_total = $sub_total;
        $order->tax = ($sub_total * 1.09) - $sub_total;
        $order->total = $sub_total + $order->shipping;
        $order->save();
    }
}
