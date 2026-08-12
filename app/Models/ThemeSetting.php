<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ThemeSetting extends Model
{
    protected $fillable = [
        'primary_color',
        'secondary_color',
        'accent_color',
        'light_color',
        'very_light_color',
        'dark_color',
        'backgrond_image',
        'decor_top_left_image',
        'decor_top_right_image',
        'decor_bottom_left_image',
        'decor_bottom_right_image',
        'decor_falling_petal_image',
        'bg_mask_alpha',
        'hero_mask_alpha',
        'couple_and_decor'
    ];

    /**
     * Check if background is a video file
     */
    public function isBackgroundVideo()
    {
        if (!$this->backgrond_image) {
            return false;
        }

        $extension = strtolower(pathinfo($this->backgrond_image, PATHINFO_EXTENSION));
        return in_array($extension, ['mp4', 'mov', 'ogg', 'webm']);
    }

    /**
     * Check if background is an image file
     */
    public function isBackgroundImage()
    {
        if (!$this->backgrond_image) {
            return false;
        }

        $extension = strtolower(pathinfo($this->backgrond_image, PATHINFO_EXTENSION));
        return in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'webp']);
    }

    /**
     * Get background URL
     */
    public function getBackgroundUrlAttribute()
    {
        if ($this->backgrond_image) {
            return Storage::url($this->backgrond_image);
        }
        return null;
    }
}
