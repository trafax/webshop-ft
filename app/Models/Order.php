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
        'nr', 'sub_total', 'tax', 'shipping', 'total', 'payment_method', 'status', 'date'
    ];

    public function rules()
    {
        return $this->belongsToMany('App\Models\OrderRule', 'order_rules', '', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\OrderCustomer', 'order_customer', '', 'customer_id');
    }
}
