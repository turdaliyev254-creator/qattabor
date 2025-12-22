<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = ['category_id', 'name', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
