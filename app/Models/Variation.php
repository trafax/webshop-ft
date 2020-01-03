<?php

namespace App\Models;

use App\Traits\Uuids;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use Uuids;
    use SoftDeletes;
    use Sluggable;

    public $incrementing = false;

    public $fillable = [
        'title', 'selectable', 'hide', 'sort', 'sort_by', 'old_id', 'show_ordered'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
