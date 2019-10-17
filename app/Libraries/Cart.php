<?php

namespace App\Libraries;

use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart as GloudemansCart;

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
            return $total + ($cartItem->qty * $cartItem->priceTax);
        }, 0);

        $total += self::shipping();

        return self::numberFormat($total, $decimals, $decimalPoint, $thousandSeperator);
    }

    public static function shipping($display = false)
    {
        $price = 0;

        return $display == true ? self::numberFormat($price, null, null, null) : $price;
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
