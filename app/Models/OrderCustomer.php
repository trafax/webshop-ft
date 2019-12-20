<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OrderCustomer extends Model
{
    public $table = 'order_customer';

    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = 'order_id';

    public $fillable = [
        'order_id', 'user_id', 'firstname', 'preposition', 'lastname', 'email', 'street', 'number', 'zipcode', 'city', 'language_key', 'telephone', 'other_delivery', 'delivery_street', 'delivery_number', 'delivery_language_key', 'delivery_zipcode', 'delivery_city', 'delivery_language_key'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    public function rules()
    {
        return $this->hasMany('App\Models\OrderRule', 'order_id', 'order_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
