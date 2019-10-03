<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    public $table = 'product_variation';

    public $fillable = [
        'product_id', 'variation_id', 'title', 'slug'
    ];

    public function scopeSlugs($query, $slugs)
    {
        return $query->whereIn('slug', $slugs)->groupBy('product_id');
    }
}
