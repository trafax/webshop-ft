<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use Uuids;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'preposition', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'user_id', 'id')->withDefault(function() {
            return new Customer();
        });
    }

    public function orders()
    {
        return $this->hasMany('App\Models\OrderCustomer', 'user_id', 'id');
    }

    public function order_amounts()
    {
        return $this->hasMany('App\Models\OrderCustomer', 'user_id', 'id');
    }
}
