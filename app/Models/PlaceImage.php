<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PlaceImage extends Model
{
    protected $fillable = ['place_id', 'image_path', 'media_type', 'thumbnail_path', 'duration', 'order'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail_path) {
            return Storage::url($this->thumbnail_path);
        }
        return $this->isVideo() ? null : $this->getImageUrlAttribute();
    }

    public function isVideo()
    {
        return $this->media_type === 'video';
    }

    public function isImage()
    {
        return $this->media_type === 'image';
    }

    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return null;
        }
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
