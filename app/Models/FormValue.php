<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormValue extends Model
{
    use Uuids;
    use SoftDeletes;

    public $table = 'form_field_values';

    public $incrementing = false;

    public $fillable = [
        'parent_id', 'title', 'sort'
    ];

    public function field()
    {
        return $this->hasOne('App\Models\FormField', 'id', 'parent_id');
    }
}
