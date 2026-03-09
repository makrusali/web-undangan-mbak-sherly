<?php

namespace App\Http\Controllers;

use App\Models\InvitationSetting;
use App\Models\WeddingEvent;
use App\Models\Gallery;
use App\Models\Guest;
use App\Models\Wish;
use App\Models\InvitationAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    public function index(Request $request)
    {
        // Track invitation access
        InvitationAccess::track($request);

        // Get invitation settings
        $setting = InvitationSetting::first();

        // If no settings exist, show a friendly message
        if (!$setting) {
            return view('pages.invitation.not-ready');
        }

        // Get wedding events
        $events = WeddingEvent::where('is_active', true)
            ->orderBy('date')
            ->orderBy('time_start')
            ->get();

        // Get galleries
        $galleries = Gallery::orderBy('sort_order')->get();

        // Get approved wishes
        $wishes = Wish::where('is_approved', true)
            ->latest()
            ->take(20)
            ->get();

        return view('pages.invitation.index', compact('setting', 'events', 'galleries', 'wishes'));
    }

    /**
     * Store a new wish
     */
    public function storeWish(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $wish = Wish::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'is_approved' => true, // Default to pending
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your wishes!',
            'wish' => $wish
        ]);
    }

    /**
     * Get wishes for API
     */
    public function getWishes()
    {
        $wishes = Wish::where('is_approved', true)
            ->latest()
            ->take(20)
            ->get();

        return response()->json($wishes);
    }

    /**
     * Optional: View invitation for a specific guest
     */
    public function guest(Request $request, $guestId = null)
    {
        // Track invitation access
        InvitationAccess::track($request);

        // Get invitation settings
        $setting = InvitationSetting::first();

        if (!$setting) {
            return view('pages.invitation.not-ready');
        }

        // Get wedding events
        $events = WeddingEvent::where('is_active', true)
            ->orderBy('date')
            ->orderBy('time_start')
            ->get();

        // Get galleries
        $galleries = Gallery::orderBy('sort_order')->get();

        // Get approved wishes
        $wishes = Wish::where('is_approved', true)
            ->latest()
            ->take(20)
            ->get();

        // If guest ID is provided, load guest-specific data
        $maxGuest = $setting->max_guest;
        $guest = null;
        $guestName = 'Bapak/Ibu/Saudara/i';

        if ($guestId) {
            $guest = Guest::find($guestId);
            if ($guest) {
                $guestName = $guest->name;
            }
        }

        $text = $setting->invitation_text ?? '';
        $text = str_replace('{{guest}}', $guestName, $text);
        $text = str_replace('{{max_guest}}', $maxGuest ? (string)$maxGuest : '', $text);

        $setting->invitation_text_with_guest = $text;

        return view('pages.invitation.index', compact('setting', 'events', 'galleries', 'wishes', 'guest'));
    }
}
