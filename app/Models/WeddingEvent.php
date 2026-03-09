<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class WeddingEvent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'date',
        'time_start',
        'time_end',
        'location_name',
        'description',
        'image',
        'gmaps_link',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'time_start' => 'datetime:H:i',
        'time_end' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /**
     * Get formatted time range
     */
    public function getFormattedTimeAttribute()
    {
        $start = $this->time_start ? $this->time_start->format('H:i') : '';
        $end = $this->time_end ? $this->time_end->format('H:i') : '';

        if ($start && $end) {
            return "{$start} - {$end} WIB";
        } elseif ($start) {
            return "{$start} WIB";
        }
        return '';
    }

    /**
     * Get formatted date and time
     */
    public function getFormattedDateTimeAttribute()
    {
        $date = $this->date ? $this->date->format('l, d F Y') : '';
        $time = $this->formatted_time;

        if ($date && $time) {
            return "{$date} • {$time}";
        } elseif ($date) {
            return $date;
        }
        return '';
    }

    /**
     * Get Google Maps embed URL
     */
    public function getGmapsEmbedUrlAttribute()
    {
        if (!$this->gmaps_link) return null;

        // Extract place ID from Google Maps link
        if (preg_match('/place\/([^\/]+)/', $this->gmaps_link, $matches)) {
            return "https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q={$matches[1]}";
        }

        return null;
    }

    /**
     * Scope a query to order by sort_order and date.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('date')->orderBy('time_start');
    }

    /**
     * Scope a query to only include active events.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('time_start');
    }
}
