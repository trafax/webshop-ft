<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    public $table = 'order_customer';

    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = 'order_id';

    public $fillable = [
        'order_id', 'user_id', 'name', 'email', 'street', 'number', 'zipcode', 'city', 'language_key', 'telephone', 'other_delivery', 'delivery_street', 'delivery_number', 'delivery_language_key', 'delivery_zipcode', 'delivery_city', 'delivery_language_key'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
