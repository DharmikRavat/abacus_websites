<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->latest()
            ->get();

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name'        => 'required|string|max:255',

            'email'       => 'required|email|unique:users,email',

            'password'    => 'required|string|min:6',

            'profile'     => 'nullable|image|mimes:jpg,jpeg,png,webp',

            'type'        => 'nullable|integer',

            'permissions' => 'nullable|string',

            'status'      => 'nullable|boolean',

            'fcm_id'      => 'nullable|string',
            'teacher_enrollment_id' => 'nullable|string|max:50',
        ]);

        $profile = null;

        /*
        |--------------------------------------------------------------------------
        | Upload Profile
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile')) {

            $profile = $request->file('profile')
                ->store('teachers', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Create Teacher
        |--------------------------------------------------------------------------
        */
        $teacher = User::create([

            'name'            => $request->name,

            'profile'         => $profile,

            'slug_id'         => Str::slug($request->name),

            'email'           => $request->email,

            'email_verified_at' => null,

            'password'        => Hash::make($request->password),

            'type'            => $request->type ?? 0,

            'permissions'     => $request->permissions,

            'status'          => $request->status ?? 1,

            'fcm_id'          => $request->fcm_id,


            'role'            => 'teacher',

            'teacher_enrollment_id' => $request->teacher_enrollment_id,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher created successfully',
            'teacher' => $teacher,
        ]);
    }

    /**
     * Display specified teacher.
     */
    public function show(string $id)
    {
        $teacher = User::where('role', 'teacher')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update specified teacher.
     */
    public function update(Request $request, string $id)
    {
        $teacher = User::where('role', 'teacher')
            ->findOrFail($id);

        $request->validate([

            'name'        => 'required|string|max:255',

            'email'       => 'required|email|unique:users,email,' . $teacher->id,

            'password'    => 'nullable|string|min:6',

            'profile'     => 'nullable|image|mimes:jpg,jpeg,png,webp',

            'type'        => 'nullable|integer',

            'permissions' => 'nullable|string',

            'status'      => 'nullable|boolean',

            'fcm_id'      => 'nullable|string',

            'teacher_enrollment_id' => 'nullable|string|max:50',

        ]);
  /*
    |--------------------------------------------------------------------------
    | Upload Profile (FIXED)
    |--------------------------------------------------------------------------
    */
    $profile = $teacher->profile; // keep old image by default

    if ($request->hasFile('profile')) {

        // delete old file
        if ($teacher->profile && Storage::disk('public')->exists($teacher->profile)) {
            Storage::disk('public')->delete($teacher->profile);
        }

        // store new file (ONLY PATH, NOT URL)
        $profile = $request->file('profile')->store('teachers', 'public');
    }


        /*
        |--------------------------------------------------------------------------
        | Update Teacher
        |--------------------------------------------------------------------------
        */
        $teacher->update([

            'name'        => $request->name,

            'profile'     => $teacher->profile,

            'slug_id'     => Str::slug($request->name),

            'email'       => $request->email,

            'type'        => $request->type ?? 0,

            'permissions' => $request->permissions,

            'status'      => $request->status ?? 1,

            'fcm_id'      => $request->fcm_id,
            'teacher_enrollment_id' => $request->teacher_enrollment_id,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */
        if ($request->filled('password')) {

            $teacher->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Teacher updated successfully',
            'teacher' => $teacher,
        ]);
    }

    /**
     * Remove specified teacher.
     */
    public function destroy(string $id)
    {
        $teacher = User::where('role', 'teacher')
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Delete Profile
        |--------------------------------------------------------------------------
        */
        if (
            $teacher->profile &&
            Storage::disk('public')->exists($teacher->profile)
        ) {

            Storage::disk('public')->delete($teacher->profile);
        }

        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully',
        ]);
    }
}