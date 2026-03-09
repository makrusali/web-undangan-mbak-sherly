<?php

namespace App\Http\Controllers;

use App\Models\InvitationSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class InvitationSettingController extends Controller
{
    /**
     * Show the invitation settings form.
     */
    public function index()
    {
        // Get first setting or create empty instance
        $setting = InvitationSetting::first() ?? new InvitationSetting();

        return view('pages.invitation-settings.index', compact('setting'));
    }

    /**
     * Update the invitation settings.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Hero Image
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',

            // Texts
            'invitation_text' => 'nullable|string',
            'message_template' => 'nullable|string|max:1000',
            'max_guest' => 'required|integer|min:1|max:10',

            // Groom Info
            'groom_nickname' => 'nullable|string|max:255',
            'groom_fullname' => 'nullable|string|max:255',
            'groom_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'groom_parents' => 'nullable|string|max:500',
            'groom_instagram' => 'nullable|string|max:255',

            // Bride Info
            'bride_nickname' => 'nullable|string|max:255',
            'bride_fullname' => 'nullable|string|max:255',
            'bride_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'bride_parents' => 'nullable|string|max:500',
            'bride_instagram' => 'nullable|string|max:255',

            // Love Story and Thanks
            'love_story' => 'nullable|string',
            'thanks_message' => 'nullable|string',

            // Couple Photo
            'couple_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',

            // Song/Audio
            'song_file' => 'nullable|mimes:mp3,wav,m4a,ogg|max:10240',
            'song_title' => 'nullable|string|max:255',
            'song_artist' => 'nullable|string|max:255',
            'song_autoplay' => 'nullable|boolean',

            // Status
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        // Get or create settings
        $setting = InvitationSetting::first();

        if (!$setting) {
            $setting = new InvitationSetting();
        }

        $data = $request->except([
            'hero_image',
            'groom_photo',
            'bride_photo',
            'couple_photo',
            'song_file'
        ]);

        // Handle file uploads
        if ($request->hasFile('hero_image')) {
            // Delete old file
            if ($setting->hero_image) {
                Storage::disk('public')->delete($setting->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('invitations/hero', 'public');
        }

        if ($request->hasFile('groom_photo')) {
            if ($setting->groom_photo) {
                Storage::disk('public')->delete($setting->groom_photo);
            }
            $data['groom_photo'] = $request->file('groom_photo')->store('invitations/groom', 'public');
        }

        if ($request->hasFile('bride_photo')) {
            if ($setting->bride_photo) {
                Storage::disk('public')->delete($setting->bride_photo);
            }
            $data['bride_photo'] = $request->file('bride_photo')->store('invitations/bride', 'public');
        }

        if ($request->hasFile('couple_photo')) {
            if ($setting->couple_photo) {
                Storage::disk('public')->delete($setting->couple_photo);
            }
            $data['couple_photo'] = $request->file('couple_photo')->store('invitations/couple', 'public');
        }

        if ($request->hasFile('song_file')) {
            if ($setting->song_file) {
                Storage::disk('public')->delete($setting->song_file);
            }
            $data['song_file'] = $request->file('song_file')->store('invitations/songs', 'public');
        }

        $data['is_active'] = $request->has('is_active');
        $data['song_autoplay'] = $request->has('song_autoplay');
        $data['max_guest'] = (int)$request->get('max_guest');

        // dd($data);

        $setting->fill($data);
        $setting->save();

        return redirect()->route('panel.invitation-settings.index')
            ->with('success', 'Invitation settings updated successfully.');
    }

    /**
     * Delete hero image
     */
    public function deleteHeroImage()
    {
        $setting = InvitationSetting::first();
        if ($setting && $setting->hero_image) {
            Storage::disk('public')->delete($setting->hero_image);
            $setting->hero_image = null;
            $setting->save();

            return response()->json(['success' => true, 'message' => 'Hero image deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }

    /**
     * Delete groom photo
     */
    public function deleteGroomPhoto()
    {
        $setting = InvitationSetting::first();
        if ($setting && $setting->groom_photo) {
            Storage::disk('public')->delete($setting->groom_photo);
            $setting->groom_photo = null;
            $setting->save();

            return response()->json(['success' => true, 'message' => 'Groom photo deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }

    /**
     * Delete bride photo
     */
    public function deleteBridePhoto()
    {
        $setting = InvitationSetting::first();
        if ($setting && $setting->bride_photo) {
            Storage::disk('public')->delete($setting->bride_photo);
            $setting->bride_photo = null;
            $setting->save();

            return response()->json(['success' => true, 'message' => 'Bride photo deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }

    /**
     * Delete couple photo
     */
    public function deleteCouplePhoto()
    {
        $setting = InvitationSetting::first();
        if ($setting && $setting->couple_photo) {
            Storage::disk('public')->delete($setting->couple_photo);
            $setting->couple_photo = null;
            $setting->save();

            return response()->json(['success' => true, 'message' => 'Couple photo deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }

    /**
     * Delete song file
     */
    public function deleteSongFile()
    {
        $setting = InvitationSetting::first();
        if ($setting && $setting->song_file) {
            Storage::disk('public')->delete($setting->song_file);
            $setting->song_file = null;
            $setting->song_title = null;
            $setting->song_artist = null;
            $setting->song_autoplay = false;
            $setting->save();

            return response()->json(['success' => true, 'message' => 'Song deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Song not found'], 404);
    }
}
