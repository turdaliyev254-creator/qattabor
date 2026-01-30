<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramBroadcast extends Model
{
    protected $fillable = [
        'created_by',
        'media_type',
        'media_file_id',
        'caption',
        'target_regions',
        'links',
        'status',
        'sent_count',
        'failed_count',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'target_regions' => 'array',
        'links' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['draft', 'scheduled']);
    }

    public function getTargetRegionNames(): string
    {
        if (empty($this->target_regions) || in_array('all', $this->target_regions)) {
            return __('All Regions');
        }

        $regions = Region::whereIn('id', $this->target_regions)->pluck('name')->toArray();
        return implode(', ', $regions);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'completed' => 'bg-green-100 text-green-800',
            'sending' => 'bg-blue-100 text-blue-800',
            'failed' => 'bg-red-100 text-red-800',
            'scheduled' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
