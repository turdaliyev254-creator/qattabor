<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'slug', 'region', 'region_id'];

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    /**
     * Get the region that owns the location.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
