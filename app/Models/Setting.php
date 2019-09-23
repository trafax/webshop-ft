<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    public $fillable = [
        'field', 'value'
    ];
}
