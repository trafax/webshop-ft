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
        'sku', 'title', 'description', 'price', 'seo', 'slug', 'image', 'sold_out', 'old_id', 'visible', 'specs'
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
        return $this->belongsToMany('App\Models\Variation')->orderBy('sort')->withPivot('sort', 'slug', 'title', 'fixed_price', 'adding_price')->orderBy('pivot_sort');
    }

    public function filtered()
    {
        return 1;
    }

    public function assets()
    {
        return $this->hasMany('App\Models\Asset', 'parent_id', 'id')->orderBy('sort');
    }

    public function ordered()
    {
        return $this->hasMany('App\Models\OrderRule', 'product_id', 'id')->selectRaw('*, sum(qty) as sum')->groupBy('options');
    }
}
