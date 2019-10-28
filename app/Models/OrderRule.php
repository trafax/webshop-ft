<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OrderRule extends Model
{
    public $table = 'order_rules';

    public $incrementing = false;

    public $fillable = [
        'product_id', 'sku', 'title', 'qty', 'price'
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }
}
