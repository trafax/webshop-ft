<?php

namespace App\Models;

use App\Traits\Uuids;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use Uuids;
    use SoftDeletes;

    use Sluggable, NodeTrait {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    public $incrementing = false;

    public $fillable = [
        'parent_id', 'title', 'description', 'specs', 'seo', 'slug', 'image', '_lft', '_rgt', 'old_id'
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

    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->where('visible', 1)->orderBy('price')->orderBy('title')->withPivot('category_id');
    }
}
