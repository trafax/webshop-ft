<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Uuids;
    use SoftDeletes;

    public $incrementing = false;

    public $fillable = [
        'nr', 'sub_total', 'tax', 'shipping', 'total', 'payment_method', 'status', 'comment'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }

    public function rules()
    {
        return $this->hasMany('App\Models\OrderRule', 'order_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OrderCustomer', 'order_id', 'id');
    }
}
