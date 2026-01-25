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
        'navigate_link',
        'instagram',
        'telegram',
        'facebook',
        'youtube',
        'latitude',
        'longitude',
        'working_hours',
        'rating',
        'views_count',
        'phone_clicks',
        'website_clicks',
        'social_clicks',
        'order',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'is_popular' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-assign order on create (scoped to subcategory)
        static::creating(function ($place) {
            if (is_null($place->order)) {
                $maxOrder = static::where('subcategory_id', $place->subcategory_id)->max('order');
                $place->order = ($maxOrder ?? 0) + 1;
            }
        });

        // Renumber after delete (scoped to subcategory)
        static::deleted(function ($place) {
            static::renumberOrders($place->subcategory_id);
        });
    }

    /**
     * Renumber orders sequentially within a subcategory
     */
    public static function renumberOrders($subcategoryId = null)
    {
        if ($subcategoryId) {
            $places = static::where('subcategory_id', $subcategoryId)->orderBy('order')->get();
        } else {
            // Renumber all subcategories separately
            $subcategoryIds = static::distinct()->pluck('subcategory_id');
            foreach ($subcategoryIds as $subId) {
                static::renumberOrders($subId);
            }
            return;
        }
        
        foreach ($places as $index => $place) {
            $place->order = $index + 1;
            $place->saveQuietly();
        }
    }

    /**
     * Scope for ordering by manual order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

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

    public function images()
    {
        return $this->hasMany(PlaceImage::class)->orderBy('order');
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
