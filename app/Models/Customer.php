<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'user_id';

    public $fillable = [
        'user_id', 'street', 'number', 'zipcode', 'city', 'country', 'telephone', 'other_delivery', 'delivery_street', 'delivery_number', 'delivery_country', 'delivery_zipcode', 'delivery_city', 'delivery_country'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'language_key', 'country');
    }

    public function delivery_country()
    {
        return $this->hasOne('App\Models\Country', 'language_key', 'delivery_country');
    }
}
