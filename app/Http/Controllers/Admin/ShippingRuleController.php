<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Shipping;
use App\Models\ShippingRule;

class ShippingRuleController extends Controller
{
    public function create(Request $request)
    {
        $countries = Country::orderBy('title', 'ASC')->get();

        $shipping = Shipping::find($request->get('shipping'));

        return view('webshop.shipping.admin.rule_create', compact('countries', 'shipping'));
    }

    public function store(Request $request)
    {
        $shipping_rule = new ShippingRule();
        $shipping_rule->fill($request->all());
        $shipping_rule->save();

        return redirect()->route('admin.shipping.edit', [$shipping_rule->shipping, '#rules']);
    }

    public function edit(Request $request, $id)
    {
        $countries = Country::orderBy('title', 'ASC')->get();
        $shipping = Shipping::find($request->get('shipping'));

        $shipping_rule = ShippingRule::find($id);

        return view('webshop.shipping.admin.rule_edit', compact('countries', 'shipping', 'shipping_rule'));
    }

    public function update(Request $request, $id)
    {
        $shipping_rule = ShippingRule::find($id);

        $shipping_rule->fill($request->all());
        $shipping_rule->save();

        return redirect()->route('admin.shipping.edit', [$shipping_rule->shipping, '#rules']);
    }
    public function destroy($id)
    {
        $shipping_rule = ShippingRule::find($id);

        $shipping_rule->delete();

        return redirect()->route('admin.shipping.edit', [$shipping_rule->shipping, '#rules']);
    }
}
