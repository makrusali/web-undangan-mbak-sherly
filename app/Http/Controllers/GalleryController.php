<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->get();
        return view('pages.galleries.index', compact('galleries'));
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $uploaded = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('galleries', 'public');

            $gallery = Gallery::create([
                'path' => $path,
                'sort_order' => Gallery::max('sort_order') + 1,
            ]);

            $uploaded[] = [
                'id' => $gallery->id,
                'path' => $gallery->path,
                'image_url' => $gallery->image_url,
                'sort_order' => $gallery->sort_order,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => count($uploaded) . ' image(s) uploaded successfully',
            'images' => $uploaded
        ]);
    }

    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id' => 'required|exists:galleries,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->items as $item) {
            Gallery::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully'
        ]);
    }

    public function destroy(Gallery $gallery)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($gallery->path)) {
            Storage::disk('public')->delete($gallery->path);
        }

        // Delete record from database
        $gallery->delete();

        // Reorder remaining items
        $remaining = Gallery::orderBy('sort_order')->get();
        foreach ($remaining as $index => $item) {
            $item->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}
