<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WishController extends Controller
{
    /**
     * Display a listing of the wishes.
     */
    public function index(Request $request)
    {
        $query = Wish::query();

        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'approved':
                    $query->where('is_approved', true);
                    break;
                case 'pending':
                    $query->where('is_approved', false);
                    break;
            }
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $wishes = $query->orderBy('created_at', 'desc')->paginate(15);

        $totalWishes = Wish::count();
        $approvedWishes = Wish::where('is_approved', true)->count();
        $pendingWishes = Wish::where('is_approved', false)->count();

        return view('pages.wishes.index', compact('wishes', 'totalWishes', 'approvedWishes', 'pendingWishes'));
    }

    /**
     * Show the form for creating a new wish (public form - in separate controller maybe)
     */
    public function create()
    {
        return view('pages.wishes.create'); // Public form
    }

    /**
     * Store a newly created wish (public submission)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        Wish::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'is_approved' => false, // Default to pending
        ]);

        return redirect()->back()
            ->with('success', 'Thank you for your wishes! It will be displayed after approval.');
    }

    /**
     * Display the specified wish.
     */
    public function show(Wish $wish)
    {
        return view('pages.wishes.show', compact('wish'));
    }

    /**
     * Show the form for editing the specified wish.
     */
    public function edit(Wish $wish)
    {
        return view('pages.wishes.edit', compact('wish'));
    }

    /**
     * Update the specified wish in storage.
     */
    public function update(Request $request, Wish $wish)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        $wish->update([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('panel.wishes.index')
            ->with('success', 'Wish updated successfully.');
    }

    /**
     * Remove the specified wish from storage.
     */
    public function destroy(Wish $wish)
    {
        $name = $wish->name;
        $wish->delete();

        return redirect()->route('panel.wishes.index')
            ->with('success', "Wish deleted successfully.");
    }

    /**
     * Approve the specified wish.
     */
    public function approve(Wish $wish)
    {
        $wish->update(['is_approved' => true]);

        return redirect()->route('panel.wishes.index')
            ->with('success', 'Wish approved successfully.');
    }

    /**
     * Reject (unapprove) the specified wish.
     */
    public function reject(Wish $wish)
    {
        $wish->update(['is_approved' => false]);

        return redirect()->route('panel.wishes.index')
            ->with('success', 'Wish rejected successfully.');
    }

    /**
     * Bulk delete wishes.
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:wishes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Invalid selection.');
        }

        $count = Wish::whereIn('id', $request->ids)->delete();

        return redirect()->route('panel.wishes.index')
            ->with('success', $count . ' wish(es) deleted successfully.');
    }

    /**
     * Bulk approve wishes.
     */
    public function bulkApprove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:wishes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Invalid selection.');
        }

        $count = Wish::whereIn('id', $request->ids)->update(['is_approved' => true]);

        return redirect()->route('panel.wishes.index')
            ->with('success', $count . ' wish(es) approved successfully.');
    }
}
