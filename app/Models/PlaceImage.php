<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PlaceImage extends Model
{
    protected $fillable = ['place_id', 'image_path', 'order'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }
}
