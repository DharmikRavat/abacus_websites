<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'nullable|string|max:255',
            'media_type'    => 'required|integer',
            'media'         => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'youtube_link'  => 'nullable|string',
            'is_active'     => 'required|boolean',
            'is_dashboard'  => 'required|boolean',
        ]);

        $mediaName = null;

        if ($request->hasFile('media')) {

            $file = $request->file('media');

            $mediaName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/gallery'), $mediaName);
        }

        $gallery = Gallery::create([
            'title'         => $request->title,
            'media_type'    => $request->media_type,
            'media'         => $mediaName,
            'youtube_link'  => $request->youtube_link,
            'is_active'     => $request->is_active,
            'is_dashboard'  => $request->is_dashboard,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery created successfully',
            'gallery' => $gallery,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        return response()->json([
            'success' => true,
            'gallery' => $gallery,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'         => 'nullable|string|max:255',
            'media_type'    => 'required|integer',
            'media'         => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'youtube_link'  => 'nullable|string',
            'is_active'     => 'required|boolean',
            'is_dashboard'  => 'required|boolean',
        ]);

        $gallery = Gallery::findOrFail($id);

        $mediaName = $gallery->media;

        if ($request->hasFile('media')) {

            $oldPath = public_path('uploads/gallery/' . $gallery->media);

            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('media');

            $mediaName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/gallery'), $mediaName);
        }

        $gallery->update([
            'title'         => $request->title,
            'media_type'    => $request->media_type,
            'media'         => $mediaName,
            'youtube_link'  => $request->youtube_link,
            'is_active'     => $request->is_active,
            'is_dashboard'  => $request->is_dashboard,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery updated successfully',
            'gallery' => $gallery,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        $filePath = public_path('uploads/gallery/' . $gallery->media);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery deleted successfully',
        ]);
    }
}
