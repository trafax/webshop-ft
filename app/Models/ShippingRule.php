<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    use Uuids;

    public $incrementing = false;

    public $fillable = [
        'shipping_id', 'country_id', 'price', 'free_from'
    ];

    public function shipping()
    {
        return $this->hasOne('App\Models\Shipping', 'id', 'shipping_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }
}
