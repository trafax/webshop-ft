<?php

namespace App\Models;

use App\Traits\Uuids;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Uuids;
    use SoftDeletes;

    use Sluggable {
        Sluggable::replicate as replicateSlug;
    }

    public $incrementing = false;

    public $fillable = [
        'title', 'description', 'price', 'seo', 'slug', 'image'
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

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function variations()
    {
        return $this->belongsToMany('App\Models\Variation')->withPivot('title', 'fixed_price', 'adding_price');
    }

    public function assets()
    {
        return $this->hasMany('App\Models\Asset', 'parent_id', 'id')->orderBy('sort');
    }
}