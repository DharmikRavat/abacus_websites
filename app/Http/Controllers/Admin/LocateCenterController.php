<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use Illuminate\Http\Request;

class LocateCenterController extends Controller
{
  
    /**
     * Display a listing of centers.
     */
    public function index()
    {
        $centers = Center::latest()->get();

        return view('admin.locate-centers.index', compact('centers'));
    }

    /**
     * Store a newly created center.
     */
    public function store(Request $request)
    {
        $request->validate([

            'country_name'            => 'nullable|string|max:255',

            'state_name'              => 'nullable|string|max:255',

            'district_name'           => 'nullable|string|max:255',

            'center_name'             => 'required|string|max:255',

            'center_address'          => 'nullable|string',

            'center_contact'          => 'nullable|string|max:20',

            'assigned_teacher_id'     => 'nullable|integer',

            'assigned_teacher_name'   => 'nullable|string|max:255',

            'assigned_teacher_about'  => 'nullable|string',

        ]);

        $center = Center::create([

            'country_name'            => $request->country_name,

            'state_name'              => $request->state_name,

            'district_name'           => $request->district_name,

            'center_name'             => $request->center_name,

            'center_address'          => $request->center_address,

            'center_contact'          => $request->center_contact,

            'assigned_teacher_id'     => $request->assigned_teacher_id,

            'assigned_teacher_name'   => $request->assigned_teacher_name,

            'assigned_teacher_about'  => $request->assigned_teacher_about,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Center created successfully',
            'center'  => $center,
        ]);
    }

    /**
     * Display the specified center.
     */
    public function show(string $id)
    {
        $center = Center::findOrFail($id);

        return response()->json([
            'success' => true,
            'center'  => $center,
        ]);
    }

    /**
     * Update the specified center.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'country_name'            => 'nullable|string|max:255',

            'state_name'              => 'nullable|string|max:255',

            'district_name'           => 'nullable|string|max:255',

            'center_name'             => 'required|string|max:255',

            'center_address'          => 'nullable|string',

            'center_contact'          => 'nullable|string|max:20',

            'assigned_teacher_id'     => 'nullable|integer',

            'assigned_teacher_name'   => 'nullable|string|max:255',

            'assigned_teacher_about'  => 'nullable|string',

        ]);

        $center = Center::findOrFail($id);

        $center->update([

            'country_name'            => $request->country_name,

            'state_name'              => $request->state_name,

            'district_name'           => $request->district_name,

            'center_name'             => $request->center_name,

            'center_address'          => $request->center_address,

            'center_contact'          => $request->center_contact,

            'assigned_teacher_id'     => $request->assigned_teacher_id,

            'assigned_teacher_name'   => $request->assigned_teacher_name,

            'assigned_teacher_about'  => $request->assigned_teacher_about,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Center updated successfully',
            'center'  => $center,
        ]);
    }

    /**
     * Remove the specified center.
     */
    public function destroy(string $id)
    {
        $center = Center::findOrFail($id);

        $center->delete();

        return response()->json([
            'success' => true,
            'message' => 'Center deleted successfully',
        ]);
    }
}