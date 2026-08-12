<?php

namespace App\Http\Controllers;

use App\Excel\GuestsImport;
use App\Excel\GuestsTemplateExport;
use App\Models\Guest;
use App\Models\InvitationSetting;
use App\Models\WeddingEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{
    /**
     * Display a listing of the guests.
     */
    public function index(Request $request)
    {
        $guests = Guest::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            })
            ->paginate(10);

        // Get invitation settings
        $setting = InvitationSetting::first();

        // Get max_guest from settings

        // Get wedding events
        $events = WeddingEvent::where('is_active', true)
            ->orderBy('date')
            ->orderBy('time_start')
            ->get();

        // Process message template for each guest
        foreach ($guests as $guest) {
            $maxGuest = $guest->max_person ? $guest->max_person : $setting->max_guest ?? null;

            if ($setting && $setting->message_template) {
                // Get raw HTML from Quill
                $html = $setting->message_template;

                // Convert HTML to plain text with line breaks
                $message = $this->convertHtmlToPlainText($html);

                // Replace {{guest}} with guest name
                $message = str_replace('{{guest}}', $guest->name, $message);

                // Generate invitation URL
                $invitationUrl = route('invitation.guest', $guest->id);

                // Replace {{invitation_url}} with the actual URL
                $message = str_replace('{{invitation_url}}', $invitationUrl, $message);

                // Format event details with emojis
                $eventDetails = '';
                foreach ($events as $index => $event) {
                    $formattedDate = $event->date->translatedFormat('l, d F Y');
                    $startTime = $event->time_start->format('H:i');
                    $endTime = $event->time_end ? $event->time_end->format('H:i') : 'Selesai';

                    $eventDetails .= "\n";
                    $eventDetails .= "━━━━━━━━━━━━━━━━━━\n";
                    $eventDetails .= "✨ *{$event->name}* ✨\n";
                    $eventDetails .= "━━━━━━━━━━━━━━━━━━\n";
                    $eventDetails .= "📅 *Tanggal:* {$formattedDate}\n";
                    $eventDetails .= "⏰ *Waktu:* {$startTime} - {$endTime} WIB\n";
                    $eventDetails .= "📍 *Lokasi:* {$event->location_name}\n";

                    if ($event->address) {
                        $eventDetails .= "🏠 *Alamat:* {$event->address}\n";
                    }

                    if ($event->gmaps_link) {
                        $eventDetails .= "🗺️ *Google Maps:* {$event->gmaps_link}\n";
                    }
                }

                // Replace {event_details} with formatted events
                $message = str_replace('{{event_details}}', $eventDetails, $message);

                // Add max guest info to message template
                if ($maxGuest) {
                    $maxGuestText = "\n\n📌 *Maksimal {$maxGuest} orang per undangan*\nMohon konfirmasi jumlah tamu yang hadir.\n";

                    // Check if {{max_guest}} placeholder exists
                    if (strpos($message, '{{max_guest}}') !== false) {
                        $message = str_replace('{{max_guest}}', $maxGuest, $message);
                    } else {
                        $message .= $maxGuestText;
                    }
                } else {
                    $message = str_replace('{{max_guest}}', '', $message);
                }

                $guest->processed_message = $message;
                $guest->invitation_url = $invitationUrl;

                // Generate WhatsApp link with correct API format
                if ($guest->phone) {
                    // Clean phone number
                    $phoneNumber = preg_replace('/[^0-9]/', '', $guest->phone);

                    // Convert to international format
                    if (substr($phoneNumber, 0, 1) === '0') {
                        $phoneNumber = '62' . substr($phoneNumber, 1);
                    } elseif (substr($phoneNumber, 0, 2) !== '62') {
                        $phoneNumber = '62' . $phoneNumber;
                    }

                    // Encode message for URL
                    $encodedMessage = urlencode($message);

                    // Use the correct WhatsApp API URL format
                    $guest->whatsapp_link = "https://api.whatsapp.com/send?phone={$phoneNumber}&text={$encodedMessage}";
                } else {
                    $guest->whatsapp_link = null;
                }
            } else {
                $guest->processed_message = null;
                $guest->whatsapp_link = null;
                $guest->invitation_url = $guest->id ? route('invitation.guest', $guest->id) : null;
            }
        }

        return view('pages.guests.index', compact('guests', 'setting', 'maxGuest'));
    }

    /**
     * Convert HTML from Quill to plain text with proper line breaks
     */
    private function convertHtmlToPlainText($html)
    {
        if (empty($html)) {
            return '';
        }

        // Replace <p> tags with newlines
        $text = preg_replace('/<p[^>]*>/', '', $html);
        $text = preg_replace('/<\/p>/', "\n", $text);

        // Replace <br> and <br/> with newlines
        $text = preg_replace('/<br\s*\/?>/', "\n", $text);

        // Replace <div> tags with newlines
        $text = preg_replace('/<div[^>]*>/', '', $text);
        $text = preg_replace('/<\/div>/', "\n", $text);

        // Replace <h1-6> tags with newlines
        $text = preg_replace('/<h[1-6][^>]*>/', "\n", $text);
        $text = preg_replace('/<\/h[1-6]>/', "\n", $text);

        // Replace <li> tags with bullet points
        $text = preg_replace('/<li[^>]*>/', "• ", $text);
        $text = preg_replace('/<\/li>/', "\n", $text);

        // Remove all other HTML tags
        $text = strip_tags($text);

        // Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Replace multiple newlines with double newlines (preserve paragraph breaks)
        $text = preg_replace("/\n\s*\n\s*\n/", "\n\n", $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        // Trim excess whitespace
        $text = trim($text);

        return $text;
    }

    /**
     * Show the form for creating a new guest.
     */
    public function create()
    {
        $setting = InvitationSetting::first();
        $maxGuest = $setting ? $setting->max_guest : null;

        return view('pages.guests.create', compact('maxGuest'));
    }

    public function show(Guest $guest)
    {
        $setting = InvitationSetting::first();
        return view('pages.guests.show', compact('guest', 'setting'));
    }

    /**
     * Store a newly created guest in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guests' => 'required|array|min:1',
            'guests.*.name' => 'required|string|max:255',
            'guests.*.phone' => 'required|string|max:20',
            'guests.*.address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        foreach ($request->guests as $guestData) {
            Guest::create($guestData);
        }

        return redirect()->route('panel.guests.index')
            ->with('success', count($request->guests) . ' guest(s) created successfully.');
    }

    /**
     * Show the form for editing the specified guest.
     */
    public function edit(Guest $guest)
    {
        $setting = InvitationSetting::first();
        $maxGuest = $setting ? $setting->max_guest : null;

        return view('pages.guests.edit', compact('guest', 'maxGuest'));
    }

    /**
     * Update the specified guest in storage.
     */
    public function update(Request $request, Guest $guest)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        $guest->update($request->all());

        return redirect()->route('panel.guests.index')
            ->with('success', 'Guest updated successfully.');
    }

    /**
     * Remove the specified guest from storage.
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect()->route('panel.guests.index')
            ->with('success', 'Guest deleted successfully.');
    }


    public function downloadTemplate()
    {
        $headers = [
            'name',
            'phone',
            'address',
        ];

        $sampleData = [];

        return Excel::download(new GuestsTemplateExport($headers, $sampleData), 'guests-template.xlsx');
    }

    /**
     * Import guests from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new GuestsImport(
                $request->has('skip_duplicates'),
                $request->has('update_existing')
            );

            Excel::import($import, $request->file('file'));

            $stats = $import->getStats();

            return redirect()->route('panel.guests.index')
                ->with('success', "Import completed: {$stats['created']} created, {$stats['updated']} updated, {$stats['skipped']} skipped.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
