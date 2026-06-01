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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'required|boolean',
        ]);
    
        $imagePath = null;
    
        // UPLOAD IMAGE
        if ($request->hasFile('image')) {
    
            $image = $request->file('image');
    
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('uploads/academy-programs'), $imageName);
    
            $imagePath = 'uploads/academy-programs/' . $imageName;
        }
    
        $academyProgram = AcademyProgram::create([
            'name'        => $request->name,
            'description' => $request->description,
            'duration'    => $request->duration,
            'image'       => $imagePath,
            'is_active'   => $request->is_active,
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'required|boolean',
        ]);
    
        $academyProgram = AcademyProgram::findOrFail($id);
    
        $imagePath = $academyProgram->image;
    
        // UPDATE IMAGE
        if ($request->hasFile('image')) {
    
            // DELETE OLD IMAGE
            if ($academyProgram->image && File::exists(public_path($academyProgram->image))) {
                File::delete(public_path($academyProgram->image));
            }
    
            $image = $request->file('image');
    
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('uploads/academy-programs'), $imageName);
    
            $imagePath = 'uploads/academy-programs/' . $imageName;
        }
    
        $academyProgram->update([
            'name'        => $request->name,
            'description' => $request->description,
            'duration'    => $request->duration,
            'image'       => $imagePath,
            'is_active'   => $request->is_active,
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

        $academyProgram->delete();

        return response()->json([
            'success' => true,
            'message' => 'Academy Program deleted successfully',
        ]);
    }
}