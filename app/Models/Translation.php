<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    public $fillable = [
        'parent_id', 'language_key', 'field', 'value'
    ];
}
