<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use Uuids;
    use SoftDeletes;

    use Sluggable {
        Sluggable::replicate as replicateSlug;
    }

    public $incrementing = false;

    public $fillable = [
        'parent_id', 'title', 'slug', 'seo', 'show_in_menu', 'sort'
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

    public function children()
    {
        return $this->hasMany('App\Models\Page', 'parent_id', 'id');
    }

    public function blocks()
    {
        return $this->hasMany('App\Models\Block', 'parent_id', 'id')->orderBy('sort');
    }
}
