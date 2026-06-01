<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AboutUsController extends Controller
{
    /**
     * Display the About Us data.
     */
    public function index()
    {
        $about = AboutUs::latest()->first();

        return view('admin.about-us.index', compact('about'));
    }

    /**
     * Store newly created About Us.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'description_one'  => 'nullable|string',
    
            'abacus_advantage' => 'nullable|string',
    
            'advantage_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp',
    
            'vision'           => 'nullable|array',
            'vision.*'         => 'nullable|string',
    
            'mission'          => 'nullable|array',
            'mission.*'        => 'nullable|string',
        ]);
    
        $folderPath = public_path('about');
    
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    
        $userImage = null;
        $advantageImage = null;
    
        // USER IMAGE
        if ($request->hasFile('user_image')) {
    
            $file = $request->file('user_image');
    
            $filename = time() . '_user_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    
            $file->move($folderPath, $filename);
    
            $userImage = 'about/' . $filename;
        }
    
        // ADVANTAGE IMAGE
        if ($request->hasFile('advantage_image')) {
    
            $file = $request->file('advantage_image');
    
            $filename = time() . '_advantage_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    
            $file->move($folderPath, $filename);
    
            $advantageImage = 'about/' . $filename;
        }
    
        $about = AboutUs::create([
            'user_image'       => $userImage,
    
            'description_one'  => $request->description_one,
    
            'abacus_advantage' => $request->abacus_advantage,
    
            'advantage_image'  => $advantageImage,
    
            'vision'           => array_values(array_filter($request->vision ?? [])),
    
            'mission'          => array_values(array_filter($request->mission ?? [])),
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'About Us created successfully',
            'about'   => $about,
        ]);
    }
    /**
     * Display specified About Us.
     */
    public function show(string $id)
    {
        $about = AboutUs::findOrFail($id);

        return response()->json([
            'success' => true,
            'about'   => $about,
        ]);
    }

    /**
     * Update About Us.
     */
    public function update(Request $request, string $id)
    {
        $about = AboutUs::findOrFail($id);
    
        $request->validate([
            'user_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'description_one'  => 'nullable|string',
    
            'abacus_advantage' => 'nullable|string',
    
            'advantage_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp',
    
            'vision'           => 'nullable|array',
            'vision.*'         => 'nullable|string',
    
            'mission'          => 'nullable|array',
            'mission.*'        => 'nullable|string',
        ]);
    
        // Create folder if not exists
        $folderPath = public_path('about');
    
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
    
        // USER IMAGE
        if ($request->hasFile('user_image')) {
    
            // Delete old image
            if ($about->user_image && file_exists(public_path($about->user_image))) {
                unlink(public_path($about->user_image));
            }
    
            $file = $request->file('user_image');
    
            $filename = time() . '_user_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    
            $file->move($folderPath, $filename);
    
            $about->user_image = 'about/' . $filename;
        }
    
        // ADVANTAGE IMAGE
        if ($request->hasFile('advantage_image')) {
    
            // Delete old image
            if ($about->advantage_image && file_exists(public_path($about->advantage_image))) {
                unlink(public_path($about->advantage_image));
            }
    
            $file = $request->file('advantage_image');
    
            $filename = time() . '_advantage_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    
            $file->move($folderPath, $filename);
    
            $about->advantage_image = 'about/' . $filename;
        }
    
        $about->update([
            'user_image'       => $about->user_image,
    
            'description_one'  => $request->description_one,
    
            'abacus_advantage' => $request->abacus_advantage,
    
            'advantage_image'  => $about->advantage_image,
    
            'vision'           => array_values(array_filter($request->vision ?? [])),
    
            'mission'          => array_values(array_filter($request->mission ?? [])),
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'About Us updated successfully',
            'about'   => $about,
        ]);
    }

    /**
     * Remove About Us.
     */
    public function destroy(string $id)
    {
        $about = AboutUs::findOrFail($id);

        if ($about->user_image && Storage::disk('public')->exists($about->user_image)) {
            Storage::disk('public')->delete($about->user_image);
        }

        if ($about->advantage_image && Storage::disk('public')->exists($about->advantage_image)) {
            Storage::disk('public')->delete($about->advantage_image);
        }

        $about->delete();

        return response()->json([
            'success' => true,
            'message' => 'About Us deleted successfully',
        ]);
    }
}