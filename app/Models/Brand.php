<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'subcategory_id',
        'name',
        'name_uz',
        'name_ru',
        'name_en',
        'slug',
        'icon',
        'order',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
                
                // Ensure uniqueness
                $count = 1;
                $originalSlug = $brand->slug;
                while (static::where('slug', $brand->slug)->exists()) {
                    $brand->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            // Auto-assign order if not set
            if (empty($brand->order)) {
                $maxOrder = static::where('subcategory_id', $brand->subcategory_id)->max('order');
                $brand->order = ($maxOrder ?? 0) + 1;
            }
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('name') && !$brand->isDirty('slug')) {
                $brand->slug = Str::slug($brand->name);
                
                // Ensure uniqueness (excluding current brand)
                $count = 1;
                $originalSlug = $brand->slug;
                while (static::where('slug', $brand->slug)->where('id', '!=', $brand->id)->exists()) {
                    $brand->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Get the subcategory that owns the brand.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Get the places for the brand.
     */
    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    /**
     * Scope a query to order brands by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the localized name attribute based on current locale.
     */
    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        
        $localizedName = match($locale) {
            'uz' => $this->name_uz,
            'ru' => $this->name_ru,
            'en' => $this->name_en,
            default => $this->name_uz,
        };

        return $localizedName ?: $this->name;
    }

    /**
     * Get the icon URL.
     */
    public function getIconUrlAttribute()
    {
        return $this->icon ? asset('images/brands/' . $this->icon) : null;
    }

    /**
     * Renumber orders for all brands in a subcategory.
     */
    public static function renumberOrders($subcategoryId)
    {
        $brands = static::where('subcategory_id', $subcategoryId)
            ->orderBy('order')
            ->get();

        foreach ($brands as $index => $brand) {
            $brand->order = $index + 1;
            $brand->saveQuietly();
        }
    }
}
