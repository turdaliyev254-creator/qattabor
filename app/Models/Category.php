<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'color', 'image', 'order'];

    protected static function boot()
    {
        parent::boot();

        // Auto-assign order on create
        static::creating(function ($category) {
            if (is_null($category->order)) {
                $category->order = static::max('order') + 1;
            }
        });

        // Renumber after delete
        static::deleted(function () {
            static::renumberOrders();
        });
    }

    /**
     * Renumber all orders sequentially
     */
    public static function renumberOrders()
    {
        $categories = static::orderBy('order')->get();
        foreach ($categories as $index => $category) {
            $category->order = $index + 1;
            $category->saveQuietly();
        }
    }

    /**
     * Scope for ordering by manual order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
