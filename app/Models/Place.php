<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'owner_id',
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
        'views_count',
        'phone_clicks',
        'website_clicks',
        'social_clicks',
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementPhoneClicks()
    {
        $this->increment('phone_clicks');
    }

    public function incrementWebsiteClicks()
    {
        $this->increment('website_clicks');
    }

    public function incrementSocialClicks()
    {
        $this->increment('social_clicks');
    }
}
