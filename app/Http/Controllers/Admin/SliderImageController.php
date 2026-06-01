<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sliders;
use Illuminate\Http\Request;

class SliderImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Sliders::latest()->get();

        return view('admin.slider-images.index', compact('sliders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'  => 'required|image|mimes:jpg,jpeg,png,webp',
            'status' => 'required|boolean',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/sliders'), $imageName);
        }

        $slider = Sliders::create([
            'image'  => $imageName,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Slider created successfully',
            'slider'  => $slider,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Sliders::findOrFail($id);

        return response()->json([
            'success' => true,
            'slider'  => $slider,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'status' => 'required|boolean',
        ]);

        $slider = Sliders::findOrFail($id);

        $imageName = $slider->image;

        if ($request->hasFile('image')) {

            // Delete old image
            $oldPath = public_path('uploads/sliders/' . $slider->image);

            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Upload new image
            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/sliders'), $imageName);
        }

        $slider->update([
            'image'  => $imageName,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Slider updated successfully',
            'slider'  => $slider,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Sliders::findOrFail($id);

        // Delete image
        $imagePath = public_path('uploads/sliders/' . $slider->image);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $slider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slider deleted successfully',
        ]);
    }
}
