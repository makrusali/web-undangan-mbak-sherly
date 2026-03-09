<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InvitationSetting extends Model
{
    protected $table = 'invitation_settings';

    protected $fillable = [
        'hero_image',
        'invitation_text',
        'message_template',
        'groom_nickname',
        'groom_fullname',
        'groom_photo',
        'groom_parents',
        'groom_instagram',
        'bride_nickname',
        'bride_fullname',
        'bride_photo',
        'bride_parents',
        'bride_instagram',
        'love_story',
        'couple_photo',
        'thanks_message',
        'song_file',
        'song_title',
        'song_artist',
        'song_autoplay',
        'is_active',
        'max_guest',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'song_autoplay' => 'boolean',
    ];

    public function weddingEvents()
    {
        return $this->hasMany(WeddingEvent::class)->orderBy('sort_order')->orderBy('date');
    }

    public function getHeroImageUrlAttribute()
    {
        return $this->hero_image ? Storage::url($this->hero_image) : null;
    }

    public function getGroomPhotoUrlAttribute()
    {
        return $this->groom_photo ? Storage::url($this->groom_photo) : null;
    }

    public function getBridePhotoUrlAttribute()
    {
        return $this->bride_photo ? Storage::url($this->bride_photo) : null;
    }

    public function getCouplePhotoUrlAttribute()
    {
        return $this->couple_photo ? Storage::url($this->couple_photo) : null;
    }

    public function getSongFileUrlAttribute()
    {
        return $this->song_file ? Storage::url($this->song_file) : null;
    }

    public function getSongFileSizeAttribute()
    {
        if (!$this->song_file) return null;

        $path = storage_path('app/public/' . $this->song_file);
        if (!file_exists($path)) return null;

        $bytes = filesize($path);
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes > 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get message template with guest name placeholder
     */
    public function getMessageTemplateWithGuestAttribute($guestName = 'Tamu Undangan')
    {
        return str_replace('{{guest}}', $guestName, $this->message_template ?? '');
    }

    /**
     * Get WhatsApp message for a specific guest
     */
    public function getWhatsAppMessage(Guest $guest)
    {
        $template = $this->message_template ?? "Assalamu'alaikum {{guest}}, kami mengundang Anda untuk menghadiri acara pernikahan kami. Detail acara: {event_details}";

        // Replace guest placeholder
        $message = str_replace('{{guest}}', $guest->name, $template);

        // Get event details
        $eventDetails = '';
        foreach ($this->weddingEvents as $index => $event) {
            $eventDetails .= "\n\n" . ($index + 1) . ". {$event->name}\n";
            $eventDetails .= "   📅 {$event->formatted_date_time}\n";
            $eventDetails .= "   📍 {$event->location}\n";
            $eventDetails .= "   🏠 {$event->address}";
        }

        // Replace event details placeholder
        $message = str_replace('{event_details}', $eventDetails, $message);

        return $message;
    }

    public function getCoupleNameAttribute()
    {
        return $this->groom_nickname && $this->bride_nickname
            ? $this->groom_nickname . ' & ' . $this->bride_nickname
            : 'Wedding Invitation';
    }

    public function getFullNamesAttribute()
    {
        $names = [];
        if ($this->groom_fullname) $names[] = $this->groom_fullname;
        if ($this->bride_fullname) $names[] = $this->bride_fullname;
        return implode(' & ', $names);
    }

    public function getParentsNamesAttribute()
    {
        $parents = [];
        if ($this->groom_parents) $parents[] = $this->groom_parents;
        if ($this->bride_parents) $parents[] = $this->bride_parents;
        return implode(' & ', $parents);
    }
}
