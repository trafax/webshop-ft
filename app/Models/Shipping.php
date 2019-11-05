<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use Uuids;
    use SoftDeletes;

    public $incrementing = false;

    public $fillable = [
        'title', 'default_price'
    ];

    public function rules()
    {
        return $this->hasMany('App\Models\ShippingRule', 'shipping_id', 'id');
    }
}
