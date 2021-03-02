<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Uuids;
    use SoftDeletes;

    public $incrementing = false;

    public $fillable = [
        'nr', 'sub_total', 'tax', 'shipping', 'total', 'payment_method', 'status', 'order_status', 'comment'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }

    public function rules()
    {
        return $this->hasMany('App\Models\OrderRule', 'order_id', 'id')->orderBy('sku');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OrderCustomer', 'order_id', 'id');
    }

    public static function statics($year)
    {
        $statics['year'] = $year;

        $statics['total'] = Order::where('status', 'paid')->where(function($q){ return $q->where('order_status', '!=', 'Geannuleerd')->orWhere('order_status', NULL); })->whereYear('created_at', $year)->count();
        $statics['total_amount'] = Order::selectRaw('SUM(sub_total) as total_amount')->where('status', 'paid')->where(function($q){ return $q->where('order_status', '!=', 'Geannuleerd')->orWhere('order_status', NULL); })->whereYear('created_at', $year)->first()->total_amount;
        $statics['total_shipping'] = Order::selectRaw('SUM(shipping) as total_shipping')->where('status', 'paid')->where(function($q){ return $q->where('order_status', '!=', 'Geannuleerd')->orWhere('order_status', NULL); })->whereYear('created_at', $year)->first()->total_shipping;

        return $statics;
    }

    public static function most_ordered($limit, $year = 0)
    {
        $products = OrderRule::selectRaw('product_id, options, SUM(qty) as total')->whereHas('order', function($q) use ($year) {
            $q->where('status', 'paid')->where(function($q){ return $q->where('order_status', '!=', 'Geannuleerd')->orWhere('order_status', NULL); })->whereRaw('YEAR(created_at) = ?', $year);
        })->groupBy('product_id', 'options')->orderBy('total', 'DESC')->limit($limit)->get();

        return $products;
    }
}
