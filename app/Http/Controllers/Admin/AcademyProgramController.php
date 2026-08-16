<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AcademyProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academyPrograms = AcademyProgram::latest()->get();

        return view(
            'admin.academy-programs.index',
            compact('academyPrograms')
        );
    }

    
    
     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'duration'        => 'nullable|string|max:255',
            'link'            => 'nullable|url|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'program_images.*'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_active'       => 'required|boolean',
        ]);
    
        // Main Image
        $imagePath = null;
    
        if ($request->hasFile('image')) {
    
            $image = $request->file('image');
    
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('uploads/academy-programs'), $imageName);
    
            $imagePath = 'uploads/academy-programs/' . $imageName;
        }
    
        // Multiple Program Images
        $programImages = [];
    
        if ($request->hasFile('program_images')) {
    
            foreach ($request->file('program_images') as $file) {
    
                $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
    
                $file->move(public_path('uploads/academy-programs/gallery'), $fileName);
    
                $programImages[] = 'uploads/academy-programs/gallery/' . $fileName;
            }
        }
    
        $academyProgram = AcademyProgram::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'duration'        => $request->duration,
            'link'            => $request->link,
            'image'           => $imagePath,
            'program_images'  => $programImages,
            'is_active'       => $request->is_active,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Academy Program created successfully',
            'academy_program' => $academyProgram,
        ]);
    }
    
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'duration'        => 'nullable|string|max:255',
            'link'            => 'nullable|url|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'program_images.*'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_active'       => 'required|boolean',
        ]);
    
        $academyProgram = AcademyProgram::findOrFail($id);
    
        // Main Image
        $imagePath = $academyProgram->image;
    
        if ($request->hasFile('image')) {
    
            if ($academyProgram->image && File::exists(public_path($academyProgram->image))) {
                File::delete(public_path($academyProgram->image));
            }
    
            $image = $request->file('image');
    
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('uploads/academy-programs'), $imageName);
    
            $imagePath = 'uploads/academy-programs/' . $imageName;
        }
    
// Program Images
$programImages = $academyProgram->program_images ?? [];

// If stored as JSON string, convert to array
if (!is_array($programImages)) {
    $programImages = json_decode($programImages, true) ?? [];
}

if ($request->hasFile('program_images')) {

    foreach ($request->file('program_images') as $file) {

        $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads/academy-programs/gallery'), $fileName);

        $programImages[] = 'uploads/academy-programs/gallery/' . $fileName;
    }
}
    
        $academyProgram->update([
            'name'            => $request->name,
            'description'     => $request->description,
            'duration'        => $request->duration,
            'link'            => $request->link,
            'image'           => $imagePath,
            'program_images'  => $programImages,
            'is_active'       => $request->is_active,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Academy Program updated successfully',
            'academy_program' => $academyProgram,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $academyProgram = AcademyProgram::findOrFail($id);

        return response()->json([
            'success' => true,
            'academy_program' => $academyProgram,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $academyProgram = AcademyProgram::findOrFail($id);
    
        // Delete main image
        if ($academyProgram->image && File::exists(public_path($academyProgram->image))) {
            File::delete(public_path($academyProgram->image));
        }
    
        // Delete gallery images
        if (!empty($academyProgram->program_images)) {
            foreach ($academyProgram->program_images as $image) {
                if (File::exists(public_path($image))) {
                    File::delete(public_path($image));
                }
            }
        }
    
        $academyProgram->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Academy Program deleted successfully',
        ]);
    }
}