<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use Uuids;

    public $incrementing = false;

    public $fillable = [
        'parent_id', 'file', 'sort'
    ];
}
