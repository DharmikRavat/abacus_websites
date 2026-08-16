<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalPresence;
use Illuminate\Http\Request;

class GlobalPresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $globalPresences = GlobalPresence::latest()->get();

        return view('admin.global-presences.index', compact('globalPresences'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required|string|max:255',
            'country_flag_image' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $imageName = null;

        if ($request->hasFile('country_flag_image')) {
            $image = $request->file('country_flag_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/global-presence'),
                $imageName
            );
        }

        $globalPresence = GlobalPresence::create([
            'country_name' => $request->country_name,
            'country_flag_image' => $imageName,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Global Presence created successfully',
            'data' => $globalPresence,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $globalPresence = GlobalPresence::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $globalPresence,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $globalPresence = GlobalPresence::findOrFail($id);

        $request->validate([
            'country_name' => 'required|string|max:255',
            'country_flag_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $imageName = $globalPresence->country_flag_image;

        if ($request->hasFile('country_flag_image')) {

            // Delete old image
            if (
                $globalPresence->country_flag_image &&
                file_exists(public_path('uploads/global-presence/' . $globalPresence->country_flag_image))
            ) {
                unlink(public_path('uploads/global-presence/' . $globalPresence->country_flag_image));
            }

            $image = $request->file('country_flag_image');

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/global-presence'),
                $imageName
            );
        }

        $globalPresence->update([
            'country_name' => $request->country_name,
            'country_flag_image' => $imageName,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Global Presence updated successfully',
            'data' => $globalPresence,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $globalPresence = GlobalPresence::findOrFail($id);

        if (
            $globalPresence->country_flag_image &&
            file_exists(public_path('uploads/global-presence/' . $globalPresence->country_flag_image))
        ) {
            unlink(public_path('uploads/global-presence/' . $globalPresence->country_flag_image));
        }

        $globalPresence->delete();

        return response()->json([
            'success' => true,
            'message' => 'Global Presence deleted successfully',
        ]);
    }
}