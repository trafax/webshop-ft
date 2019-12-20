<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    public $fillable = [
        'id', 'parent_id', 'sort'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'parent_id');
    }
}
