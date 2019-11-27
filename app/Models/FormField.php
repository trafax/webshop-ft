<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use Uuids;
    use SoftDeletes;

    public $incrementing = false;

    public $fillable = [
        'parent_id', 'title', 'type', 'required', 'sort'
    ];

    public function form()
    {
        return $this->hasOne('App\Models\Form', 'id', 'parent_id');
    }

    public function hasValues()
    {
        return in_array($this->type, ['dropdown', 'radio', 'checkbox']) ? TRUE : FALSE;
    }

    public function values()
    {
        return $this->hasMany('App\Models\FormValue', 'parent_id', 'id')->orderBy('sort');
    }
}
