<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OrderRule extends Model
{
    use Uuids;

    public $incrementing = false;

    public $table = 'order_rules';
    public $timestamps = false;
    public $primary = 'id';

    public $fillable = [
        'order_id', 'product_id', 'sku', 'title', 'qty', 'price', 'options', 'option_ids'
    ];

    public $casts = [
        'options' => 'array'
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
