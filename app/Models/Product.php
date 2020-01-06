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
        'sku', 'title', 'description', 'price', 'seo', 'slug', 'image', 'sold_out', 'featured', 'old_id', 'visible', 'specs', 'status'
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
        $rules = OrderRule::selectRaw('*, sum(qty) as sum')->where('product_id', $this->id)->groupBy('options')->get();

        $array = [];
        foreach ($rules as $rule)
        {
            if ($rule->order)
            {
                $array[] = $rule;
            }
        }

        return $array;

        //return $this->hasMany('App\Models\OrderRule', 'product_id', 'id')->selectRaw('*, sum(qty) as sum')->groupBy('options');
    }

    public function related()
    {
        return $this->hasMany('App\Models\RelatedProduct', 'id', 'id');
    }
}
