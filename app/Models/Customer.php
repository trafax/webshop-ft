<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'user_id';

    public $fillable = [
        'user_id', 'address', 'zipcode', 'city', 'country', 'telephone'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }
}
