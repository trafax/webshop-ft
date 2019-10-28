<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    public $table = 'order_customer';

    public $timestamps = false;

    public $incrementing = false;

    public $fillable = [
        'order_id', 'user_id', 'name', 'email', 'street', 'number', 'zipcode', 'city', 'country', 'telephone', 'other_delivery', 'delivery_street', 'delivery_number', 'delivery_country', 'delivery_zipcode', 'delivery_city', 'delivery_country'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
