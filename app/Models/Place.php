<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'location_id',
        'name',
        'slug',
        'description',
        'image_url',
        'is_popular',
        'is_featured',
        'address',
        'phone',
        'website',
        'latitude',
        'longitude',
        'working_hours',
        'rating',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_places');
    }
}
