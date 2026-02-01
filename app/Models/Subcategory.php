<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = ['category_id', 'parent_id', 'name', 'slug', 'icon', 'order', 'name_uz', 'name_ru', 'name_en'];

    protected static function boot()
    {
        parent::boot();

        // Auto-assign order on create (scoped to category)
        static::creating(function ($subcategory) {
            if (is_null($subcategory->order)) {
                $maxOrder = static::where('category_id', $subcategory->category_id)->max('order');
                $subcategory->order = ($maxOrder ?? 0) + 1;
            }
        });

        // Renumber after delete (scoped to category)
        static::deleted(function ($subcategory) {
            static::renumberOrders($subcategory->category_id);
        });
    }

    /**
     * Renumber orders sequentially within a category
     */
    public static function renumberOrders($categoryId = null)
    {
        if ($categoryId) {
            $subcategories = static::where('category_id', $categoryId)->orderBy('order')->get();
        } else {
            // Renumber all categories separately
            $categoryIds = static::distinct()->pluck('category_id');
            foreach ($categoryIds as $catId) {
                static::renumberOrders($catId);
            }
            return;
        }
        
        foreach ($subcategories as $index => $subcategory) {
            $subcategory->order = $index + 1;
            $subcategory->saveQuietly();
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

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class)->ordered();
    }

    /**
     * Get the localized name based on the current app locale
     */
    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        $fieldName = "name_{$locale}";
        
        return $this->$fieldName ?? $this->name;
    }

    /**
     * Parent subcategory relationship
     */
    public function parent()
    {
        return $this->belongsTo(Subcategory::class, 'parent_id');
    }

    /**
     * Child subcategories relationship
     */
    public function children()
    {
        return $this->hasMany(Subcategory::class, 'parent_id')->ordered();
    }

    /**
     * Scope for parent subcategories only (no parent_id)
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for child subcategories (has parent_id)
     */
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Check if this subcategory is a parent (has children)
     */
    public function isParent()
    {
        return $this->children()->exists();
    }

    /**
     * Check if this subcategory has children
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
}
