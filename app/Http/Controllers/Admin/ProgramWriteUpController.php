<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramWriteup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramWriteupController extends Controller
{
    /**
     * Show Program Writeup Page
     */
    public function index()
    {
        $programWriteup = ProgramWriteup::first();

        // Create default row if not exists
        if (!$programWriteup) {
            $programWriteup = ProgramWriteup::create([]);
        }

        return view('admin.academy-programs.academy-writeup', compact('programWriteup'));
    }

    /**
     * Update Program Writeup
     */
    public function update(Request $request)
    {
        $programWriteup = ProgramWriteup::first();

        if (!$programWriteup) {
            $programWriteup = ProgramWriteup::create([]);
        }

        $request->validate([
            'paragraph_1'        => 'nullable|string',
            'paragraph_2'        => 'nullable|string',

            'bullet_points'      => 'nullable|array',
            'bullet_points.*'    => 'nullable|string|max:500',

            'footer_title'       => 'nullable|string|max:255',
            'footer_subtitle'    => 'nullable|string|max:255',
            'footer_description' => 'nullable|string',

            'footer_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('footer_image');

        /*
        |--------------------------------------------------------------------------
        | Handle Footer Image Upload
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('footer_image')) {

            // Delete old image
            if ($programWriteup->footer_image) {

                $oldImage = public_path($programWriteup->footer_image);

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $file = $request->file('footer_image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(
                public_path('program-writeup'),
                $filename
            );

            $data['footer_image'] = 'program-writeup/' . $filename;
        }

        // Remove empty bullet points
        if ($request->has('bullet_points')) {
            $data['bullet_points'] = array_values(
                array_filter(
                    $request->bullet_points,
                    fn ($item) => !empty(trim($item))
                )
            );
        } else {
            $data['bullet_points'] = [];
        }
        $programWriteup->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Program Writeup updated successfully.'
        ]);
    }
}