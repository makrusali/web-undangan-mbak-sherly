<?php

namespace App\Http\Controllers;

use App\Models\WeddingEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WeddingEventController extends Controller
{
    /**
     * Display a listing of the wedding events.
     */
    public function index(Request $request)
    {
        $query = WeddingEvent::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Get events with ordering
        $events = $query->ordered()->paginate(15);

        // Get counts for stats
        $totalEvents = WeddingEvent::count();
        $activeEvents = WeddingEvent::where('is_active', true)->count();
        $upcomingEvents = WeddingEvent::upcoming()->count();

        return view('pages.wedding-events.index', compact('events', 'totalEvents', 'activeEvents', 'upcomingEvents'));
    }

    /**
     * Show the form for creating a new wedding event.
     */
    public function create()
    {
        return view('pages.wedding-events.create');
    }

    /**
     * Store a newly created wedding event in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'nullable|date_format:H:i|after:time_start',
            'location_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gmaps_link' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        $data = $request->except(['image']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('wedding-events', 'public');
        }

        // Set sort order if not provided
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = WeddingEvent::max('sort_order') + 1;
        }

        $data['is_active'] = $request->has('is_active');

        WeddingEvent::create($data);

        return redirect()->route('panel.wedding-events.index')
            ->with('success', 'Wedding event created successfully.');
    }

    /**
     * Display the specified wedding event.
     */
    public function show(WeddingEvent $weddingEvent)
    {
        return view('pages.wedding-events.show', compact('weddingEvent'));
    }

    /**
     * Show the form for editing the specified wedding event.
     */
    public function edit(WeddingEvent $weddingEvent)
    {
        return view('pages.wedding-events.edit', compact('weddingEvent'));
    }

    /**
     * Update the specified wedding event in storage.
     */
    public function update(Request $request, WeddingEvent $weddingEvent)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'nullable|date_format:H:i|after:time_start',
            'location_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gmaps_link' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        $data = $request->except(['image']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($weddingEvent->image) {
                Storage::disk('public')->delete($weddingEvent->image);
            }
            $data['image'] = $request->file('image')->store('wedding-events', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $weddingEvent->update($data);

        return redirect()->route('panel.wedding-events.show', $weddingEvent)
            ->with('success', 'Wedding event updated successfully.');
    }

    /**
     * Remove the specified wedding event from storage.
     */
    public function destroy(WeddingEvent $weddingEvent)
    {
        // Delete image
        if ($weddingEvent->image) {
            Storage::disk('public')->delete($weddingEvent->image);
        }

        $eventName = $weddingEvent->name;
        $weddingEvent->delete();

        return redirect()->route('panel.wedding-events.index')
            ->with('success', "Wedding event '{$eventName}' deleted successfully.");
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(WeddingEvent $weddingEvent)
    {
        $weddingEvent->update([
            'is_active' => !$weddingEvent->is_active
        ]);

        return redirect()->route('panel.wedding-events.index')
            ->with('success', 'Wedding event status updated successfully.');
    }

    /**
     * Update the order of wedding events (for drag & drop sorting).
     */
    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id' => 'required|exists:wedding_events,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid data'], 422);
        }

        foreach ($request->items as $item) {
            WeddingEvent::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully']);
    }
}
