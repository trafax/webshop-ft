<?php

namespace App\Models;

use App\Traits\Uuids;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebshopProduct extends Model
{
    use Uuids;
    use SoftDeletes;

    use Sluggable {
        Sluggable::replicate as replicateSlug;
    }

    public $incrementing = false;

    public $fillable = [
        'title', 'seo', 'slug', 'image'
    ];

    public $casts =[
        'seo' => 'array'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
