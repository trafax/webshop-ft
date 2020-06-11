<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'user_id';

    protected $connection= 'mysql_user';

    public $fillable = [
        'user_id', 'street', 'number', 'zipcode', 'city', 'language_key', 'telephone', 'other_delivery', 'delivery_street', 'delivery_number', 'delivery_language_key', 'delivery_zipcode', 'delivery_city', 'delivery_country'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'language_key', 'language_key')->withDefault(function() {
            return new Country();
        });
    }

    public function delivery_country()
    {
        return $this->hasOne('App\Models\Country', 'language_key', 'delivery_language_key');
    }
}
