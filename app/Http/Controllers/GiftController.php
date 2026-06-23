<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GiftController extends Controller
{
    /**
     * Display a listing of the gifts.
     */
    public function index()
    {
        $gifts = Gift::orderBy('created_at', 'desc')->get();
        return view('pages.gifts.index', compact('gifts'));
    }

    /**
     * Show the form for creating a new gift.
     */
    public function create()
    {
        return view('pages.gifts.create');
    }

    /**
     * Store a newly created gift in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'bank_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        $data = [
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'is_active' => $request->has('is_active'),
        ];

        // Handle bank image upload
        if ($request->hasFile('bank_image')) {
            $path = $request->file('bank_image')->store('gifts/bank-images', 'public');
            $data['bank_image'] = $path;
        }

        Gift::create($data);

        return redirect()->route('panel.gifts.index')
            ->with('success', 'Gift account created successfully.');
    }

    /**
     * Show the form for editing the specified gift.
     */
    public function edit(Gift $gift)
    {
        return view('pages.gifts.edit', compact('gift'));
    }

    /**
     * Update the specified gift in storage.
     */
    public function update(Request $request, Gift $gift)
    {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'bank_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        $data = [
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'is_active' => $request->has('is_active'),
        ];

        // Handle bank image upload
        if ($request->hasFile('bank_image')) {
            // Delete old image if exists
            if ($gift->bank_image) {
                Storage::disk('public')->delete($gift->bank_image);
            }

            $path = $request->file('bank_image')->store('gifts/bank-images', 'public');
            $data['bank_image'] = $path;
        }

        $gift->update($data);

        return redirect()->route('panel.gifts.index')
            ->with('success', 'Gift account updated successfully.');
    }

    /**
     * Remove the specified gift from storage.
     */
    public function destroy(Gift $gift)
    {
        // Delete bank image if exists
        if ($gift->bank_image) {
            Storage::disk('public')->delete($gift->bank_image);
        }

        $bankName = $gift->bank_name;
        $gift->delete();

        return redirect()->route('panel.gifts.index')
            ->with('success', "Gift account '{$bankName}' deleted successfully.");
    }

    /**
     * Delete bank image only.
     */
    public function deleteBankImage(Gift $gift)
    {
        if ($gift->bank_image) {
            Storage::disk('public')->delete($gift->bank_image);
            $gift->update(['bank_image' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Bank image deleted successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No bank image found to delete.'
        ], 404);
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Gift $gift)
    {
        $gift->update([
            'is_active' => !$gift->is_active
        ]);

        return redirect()->route('panel.gifts.index')
            ->with('success', 'Gift account status updated successfully.');
    }
}
