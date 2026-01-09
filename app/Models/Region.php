<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Region extends Model
{
    protected $fillable = [
        'name',
        'name_uz',
        'name_ru',
        'name_en',
        'slug',
        'order',
        'is_active',
        'center_latitude',
        'center_longitude'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($region) {
            if (empty($region->slug)) {
                $region->slug = Str::slug($region->name);
            }
        });

        static::updating(function ($region) {
            if (empty($region->slug)) {
                $region->slug = Str::slug($region->name);
            }
        });
    }

    /**
     * Get the locations for the region.
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get the places through locations.
     */
    public function places()
    {
        return $this->hasManyThrough(Place::class, Location::class);
    }

    /**
     * Get the localized name based on current locale.
     */
    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        
        return match($locale) {
            'uz' => $this->name_uz ?? $this->name,
            'ru' => $this->name_ru ?? $this->name,
            'en' => $this->name_en ?? $this->name,
            default => $this->name,
        };
    }

    /**
     * Scope a query to only include active regions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by the order column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Find region by coordinates using distance calculation
     */
    public static function findByCoordinates($lat, $lon, $maxDistanceKm = 200)
    {
        return self::where('is_active', true)
            ->get()
            ->map(function ($region) use ($lat, $lon) {
                if ($region->center_latitude && $region->center_longitude) {
                    $region->distance = self::calculateDistance(
                        $lat, $lon,
                        $region->center_latitude,
                        $region->center_longitude
                    );
                } else {
                    $region->distance = PHP_FLOAT_MAX;
                }
                return $region;
            })
            ->filter(function ($region) use ($maxDistanceKm) {
                return $region->distance <= $maxDistanceKm;
            })
            ->sortBy('distance')
            ->first();
    }

    /**
     * Calculate distance between two coordinates (Haversine formula)
     */
    private static function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}
