<?php

namespace App\Libraries;

use App\Models\Country;
use App\Models\Language;
use App\Models\Shipping;
use App\Models\ShippingRule;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart as GloudemansCart;
use Illuminate\Support\Facades\Auth;

class Cart extends GloudemansCart
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function total($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        $content = GloudemansCart::content();
        $total = $content->reduce(function ($total, CartItem $cartItem) {
            return $total + ($cartItem->qty * $cartItem->price);
        }, 0);

        $total += self::shipping(false, $decimals, $decimalPoint, $thousandSeperator, $total);

        return self::numberFormat($total, $decimals, $decimalPoint, $thousandSeperator);
    }

    public static function tax($decimals = null, $decimalPoint = null, $thousandSeperator = null)
    {
        $content = GloudemansCart::content();
        $total = $content->reduce(function ($total, CartItem $cartItem) {
            return $total + ($cartItem->qty * $cartItem->price);
        }, 0);

        $total = ($total / 100) * 9;

        return self::numberFormat($total, $decimals, $decimalPoint, $thousandSeperator);
    }

    public static function shipping($display = false, $decimals = null, $decimalPoint = null, $thousandSeperator = null, $total = 0)
    {
        $shipping = Shipping::find('bc0cac10-fee5-11e9-8fe9-01a4a7e73204');
        $price = $shipping->default_price;

        if (Auth::user())
        {
            $language_key = Auth::user()->customer->other_delivery == 1 ? Auth::user()->customer->delivery_language_key : Auth::user()->customer->language_key;
            $country = Country::where('language_key', $language_key)->first();

            if ($country)
            {
                $shippingRule = ShippingRule::where('country_id', $country->id)->first();

                if ($shippingRule)
                {
                    $price = $shippingRule->price;

                    if ($total >= $shippingRule->free_from && $shippingRule->free_from > 0)
                    {
                        $price = 0;
                    }
                }
            }
        }

        return $display == true ? self::numberFormat($price, $decimals, $decimalPoint, $thousandSeperator) : $price;
    }

    private static function numberFormat($value, $decimals, $decimalPoint, $thousandSeperator)
    {
        if(is_null($decimals)){
            $decimals = is_null(config('cart.format.decimals')) ? 2 : config('cart.format.decimals');
        }
        if(is_null($decimalPoint)){
            $decimalPoint = is_null(config('cart.format.decimal_point')) ? '.' : config('cart.format.decimal_point');
        }
        if(is_null($thousandSeperator)){
            $thousandSeperator = is_null(config('cart.format.thousand_seperator')) ? ',' : config('cart.format.thousand_seperator');
        }
        return number_format($value, $decimals, $decimalPoint, $thousandSeperator);
    }
}
