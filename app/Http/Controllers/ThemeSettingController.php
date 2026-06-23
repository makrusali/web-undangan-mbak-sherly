<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ThemeSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = ThemeSetting::first();
        return view('pages.theme-settings.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ThemeSetting $themeSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThemeSetting $themeSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThemeSetting $themeSetting)
    {
        $validated = $request->validate([
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'accent_color' => 'nullable|string|max:7',
            'light_color' => 'nullable|string|max:7',
            'very_light_color' => 'nullable|string|max:7',
            'dark_color' => 'nullable|string|max:7',
            // Background image supports images AND videos
            'backgrond_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,ogg,webm|max:20480', // 20MB max
            'decor_top_left_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'decor_top_right_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'decor_bottom_left_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'decor_bottom_right_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'decor_falling_petal_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'bg_mask_alpha' => 'nullable|numeric|min:0|max:1',
            'hero_mask_alpha' => 'nullable|numeric|min:0|max:1',
        ]);

        // Get the first setting or create new
        $setting = ThemeSetting::first();
        if (!$setting) {
            $setting = new ThemeSetting();
        }

        // Handle file uploads
        $imageFields = [
            'decor_top_left_image',
            'decor_top_right_image',
            'decor_bottom_left_image',
            'decor_bottom_right_image',
            'decor_falling_petal_image'
        ];

        // Handle background image/video separately
        if ($request->hasFile('backgrond_image')) {
            // Delete old file if exists
            if ($setting->backgrond_image) {
                Storage::disk('public')->delete($setting->backgrond_image);
            }

            // Store new file
            $path = $request->file('backgrond_image')->store('theme-settings', 'public');
            $setting->backgrond_image = $path;
        }

        // Handle decor images
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($setting->$field) {
                    Storage::disk('public')->delete($setting->$field);
                }

                // Store new image
                $path = $request->file($field)->store('theme-settings', 'public');
                $setting->$field = $path;
            }
        }

        // Update color fields
        $fillableFields = [
            'primary_color',
            'secondary_color',
            'accent_color',
            'light_color',
            'very_light_color',
            'dark_color',
            'bg_mask_alpha',
            'hero_mask_alpha'
        ];

        foreach ($fillableFields as $field) {
            if ($request->has($field)) {
                $setting->$field = $request->$field;
            }
        }

        $setting->save();

        return redirect()->route('panel.theme-settings.index')
            ->with('success', 'Theme settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThemeSetting $themeSetting)
    {
        //
    }

    /**
     * Delete background image/video.
     */
    public function deleteBackground(Request $request)
    {
        $setting = ThemeSetting::first();
        if ($setting && $setting->backgrond_image) {
            Storage::disk('public')->delete($setting->backgrond_image);
            $setting->backgrond_image = null;
            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Background file deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No background file found to delete'
        ], 404);
    }

    /**
     * Delete decor top left image.
     */
    public function deleteDecorTopLeft(Request $request)
    {
        $setting = ThemeSetting::first();
        if ($setting && $setting->decor_top_left_image) {
            Storage::disk('public')->delete($setting->decor_top_left_image);
            $setting->decor_top_left_image = null;
            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Decor top left image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No decor top left image found to delete'
        ], 404);
    }

    /**
     * Delete decor top right image.
     */
    public function deleteDecorTopRight(Request $request)
    {
        $setting = ThemeSetting::first();
        if ($setting && $setting->decor_top_right_image) {
            Storage::disk('public')->delete($setting->decor_top_right_image);
            $setting->decor_top_right_image = null;
            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Decor top right image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No decor top right image found to delete'
        ], 404);
    }

    /**
     * Delete decor bottom left image.
     */
    public function deleteDecorBottomLeft(Request $request)
    {
        $setting = ThemeSetting::first();
        if ($setting && $setting->decor_bottom_left_image) {
            Storage::disk('public')->delete($setting->decor_bottom_left_image);
            $setting->decor_bottom_left_image = null;
            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Decor bottom left image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No decor bottom left image found to delete'
        ], 404);
    }

    /**
     * Delete decor bottom right image.
     */
    public function deleteDecorBottomRight(Request $request)
    {
        $setting = ThemeSetting::first();
        if ($setting && $setting->decor_bottom_right_image) {
            Storage::disk('public')->delete($setting->decor_bottom_right_image);
            $setting->decor_bottom_right_image = null;
            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Decor bottom right image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No decor bottom right image found to delete'
        ], 404);
    }

    /**
     * Delete decor falling petal image.
     */
    public function deleteDecorFallingPetal(Request $request)
    {
        $setting = ThemeSetting::first();
        if ($setting && $setting->decor_falling_petal_image) {
            Storage::disk('public')->delete($setting->decor_falling_petal_image);
            $setting->decor_falling_petal_image = null;
            $setting->save();

            return response()->json([
                'success' => true,
                'message' => 'Decor falling petal image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No decor falling petal image found to delete'
        ], 404);
    }
}
