<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'color', 'image'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
