<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OrderRule extends Model
{
    public $table = 'order_rules';

    public $incrementing = false;

    public $timestamps = false;

    public $fillable = [
        'order_id', 'product_id', 'sku', 'title', 'qty', 'price', 'options', 'option_ids'
    ];

    public $casts = [
        'options' => 'array'
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }
}
