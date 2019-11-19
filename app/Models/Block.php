<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use Uuids;
    use SoftDeletes;

    public $incrementing = false;

    public $fillable = [
        'parent_id', 'type', 'block_data', 'sort'
    ];

    public $casts = ['block_data' => 'array'];

    public function text()
    {
        return $this->hasMany('App\Models\Text', 'parent_id', 'id');
    }

    public function asset()
    {
        return $this->hasOne('App\Models\Asset', 'parent_id', 'id')->withDefault(function() {
            return new Asset();
        });;
    }
}
