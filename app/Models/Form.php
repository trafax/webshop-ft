<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use Uuids;
    use SoftDeletes;

    public $incrementing = false;

    public $fillable = [
        'title', 'send_to_email', 'text_email', 'text_website', 'send_copy'
    ];

    public function fields()
    {
        return $this->hasMany('App\Models\FormField', 'parent_id', 'id')->orderBy('sort');
    }
}
