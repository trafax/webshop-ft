<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use Uuids;
    use SoftDeletes;

    public $incrementing = false;

    public $fillable = [
        'title', 'language_key'
    ];
}
