<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        $students = Customer::where('role', 'student')
            ->latest()
            ->get();

        return view('admin.students.index', compact('students'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $request->validate([

            'name'              => 'required|string|max:255',

            'email'             => 'nullable|email|unique:customers,email',

            'mobile'            => 'required|string|max:20|unique:customers,mobile',

            'password'          => 'required|string|min:6',

            'profile'           => 'nullable|image|mimes:jpg,jpeg,png,webp',

            'address'           => 'nullable|string',

            'about_me'          => 'nullable|string',

            'facebook_id'       => 'nullable|string|max:255',

            'twiiter_id'        => 'nullable|string|max:255',

            'instagram_id'      => 'nullable|string|max:255',

            'youtube_id'        => 'nullable|string|max:255',

            'latitude'          => 'nullable|string|max:255',

            'longitude'         => 'nullable|string|max:255',

            'city'              => 'nullable|string|max:255',

            'state'             => 'nullable|string|max:255',

            'country'           => 'nullable|string|max:255',

            'fcm_id'            => 'nullable|string',

            'logintype'         => 'nullable|integer',

            'is_email_verified' => 'nullable|integer',

            'status'            => 'nullable|integer',

            'notification'      => 'nullable|integer',

            'subscription'      => 'nullable|integer',

            'is_premium'        => 'nullable|integer',

            'added_by'          => 'nullable|string|max:255',

            'center_id'         => 'nullable|integer',
        ]);

        $profile = null;

        /*
        |--------------------------------------------------------------------------
        | Upload Profile
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile')) {

            $profile = $request->file('profile')
                ->store('students', 'public');
        }

          /*
    |--------------------------------------------------------------------------
    | Added By
    |--------------------------------------------------------------------------
    */

    // If using auth
    // $addedBy = Auth::id();
        // $addedBy = session('student_id');

    // OR session
    $addedBy = session('student_id');
        /*
        |--------------------------------------------------------------------------
        | Create Student
        |--------------------------------------------------------------------------
        */
        $student = Customer::create([

            'name'              => $request->name,

            'slug_id'           => Str::uuid(),

            'auth_id'           => Str::uuid(),

            'email'             => $request->email,

            'password'          => Hash::make($request->password),

            'mobile'            => $request->mobile,

            'profile'           => $profile,

            'address'           => $request->address,

            'fcm_id'            => $request->fcm_id,

            'logintype'         => $request->logintype ?? 1,

            'is_email_verified' => $request->is_email_verified ?? 0,

            'isActive'          => $request->status ?? 1,

            'api_token'         => Str::random(80),

            'notification'      => $request->notification ?? 1,

            'subscription'      => $request->subscription ?? 0,

            'about_me'          => $request->about_me,

            'facebook_id'       => $request->facebook_id,

            'twiiter_id'        => $request->twiiter_id,

            'instagram_id'      => $request->instagram_id,

            'youtube_id'        => $request->youtube_id,

            'latitude'          => $request->latitude,

            'longitude'         => $request->longitude,

            'city'              => $request->city,

            'state'             => $request->state,

            'country'           => $request->country,

            'is_premium'        => $request->is_premium ?? 0,

            'role'              => 'student',

            'added_by'          => $addedBy,

            'center_id'         => $request->center_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'student' => $student,
        ]);
    }

    public function add_student(Request $request)
    {
        $request->validate([

            'name'              => 'required|string|max:255',

            'email'             => 'nullable|email|unique:customers,email',

            'mobile'            => 'required|string|max:20|unique:customers,mobile',

            'password'          => 'required|string|min:6',

            'profile'           => 'nullable|image|mimes:jpg,jpeg,png,webp',

            'address'           => 'nullable|string',

            'about_me'          => 'nullable|string',

            'facebook_id'       => 'nullable|string|max:255',

            'twiiter_id'        => 'nullable|string|max:255',

            'instagram_id'      => 'nullable|string|max:255',

            'youtube_id'        => 'nullable|string|max:255',

            'latitude'          => 'nullable|string|max:255',

            'longitude'         => 'nullable|string|max:255',

            'city'              => 'nullable|string|max:255',

            'state'             => 'nullable|string|max:255',

            'country'           => 'nullable|string|max:255',

            'fcm_id'            => 'nullable|string',

            'logintype'         => 'nullable|integer',

            'is_email_verified' => 'nullable|integer',

            'status'            => 'nullable|integer',

            'notification'      => 'nullable|integer',

            'subscription'      => 'nullable|integer',

            'is_premium'        => 'nullable|integer',

            'added_by'          => 'nullable|string|max:255',

            'center_id'         => 'nullable|integer',
        ]);

        $profile = null;

        /*
        |--------------------------------------------------------------------------
        | Upload Profile
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile')) {

            $profile = $request->file('profile')
                ->store('students', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Create Student
        |--------------------------------------------------------------------------
        */
        $student = Customer::create([

            'name'              => $request->name,

            'slug_id'           => Str::uuid(),

            'auth_id'           => Str::uuid(),

            'email'             => $request->email,

            'password'          => Hash::make($request->password),

            'mobile'            => $request->mobile,

            'profile'           => $profile,

            'address'           => $request->address,

            'fcm_id'            => $request->fcm_id,

            'logintype'         => $request->logintype ?? 1,

            'is_email_verified' => $request->is_email_verified ?? 0,

            'isActive'          => $request->status ?? 1,

            'api_token'         => Str::random(80),

            'notification'      => $request->notification ?? 1,

            'subscription'      => $request->subscription ?? 0,

            'about_me'          => $request->about_me,

            'facebook_id'       => $request->facebook_id,

            'twiiter_id'        => $request->twiiter_id,

            'instagram_id'      => $request->instagram_id,

            'youtube_id'        => $request->youtube_id,

            'latitude'          => $request->latitude,

            'longitude'         => $request->longitude,

            'city'              => $request->city,

            'state'             => $request->state,

            'country'           => $request->country,

            'is_premium'        => $request->is_premium ?? 0,

            'role'              => 'student',

            'added_by'          => $request->added_by,

            'center_id'         => $request->center_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'student' => $student,
        ]);
    }

    /**
     * Display specified student.
     */
    public function show(string $id)
    {
        $student = Customer::where('role', 'student')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'student' => $student,
        ]);
    }

    /**
     * Update specified student.
     */
    public function update(Request $request, string $id)
    {
        $student = Customer::where('role', 'student')
            ->findOrFail($id);

        $request->validate([

            'name'              => 'required|string|max:255',

            'email'             => 'nullable|email|unique:customers,email,' . $student->id,

            'mobile'            => 'required|string|max:20|unique:customers,mobile,' . $student->id,

            'password'          => 'nullable|string|min:6',

            'profile'           => 'nullable|image|mimes:jpg,jpeg,png,webp',

            'address'           => 'nullable|string',

            'about_me'          => 'nullable|string',

            'facebook_id'       => 'nullable|string|max:255',

            'twiiter_id'        => 'nullable|string|max:255',

            'instagram_id'      => 'nullable|string|max:255',

            'youtube_id'        => 'nullable|string|max:255',

            'latitude'          => 'nullable|string|max:255',

            'longitude'         => 'nullable|string|max:255',

            'city'              => 'nullable|string|max:255',

            'state'             => 'nullable|string|max:255',

            'country'           => 'nullable|string|max:255',

            'fcm_id'            => 'nullable|string',

            'logintype'         => 'nullable|integer',

            'is_email_verified' => 'nullable|integer',

            'status'            => 'nullable|integer',

            'notification'      => 'nullable|integer',

            'subscription'      => 'nullable|integer',

            'is_premium'        => 'nullable|integer',

            'added_by'          => 'nullable|string|max:255',

            'center_id'         => 'nullable|integer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Profile
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile')) {

            if (
                $student->profile &&
                Storage::disk('public')->exists($student->profile)
            ) {

                Storage::disk('public')->delete($student->profile);
            }

            $student->profile = $request->file('profile')
                ->store('students', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Student
        |--------------------------------------------------------------------------
        */
        $student->update([

            'name'              => $request->name,

            'email'             => $request->email,

            'mobile'            => $request->mobile,

            'profile'           => $student->profile,

            'address'           => $request->address,

            'fcm_id'            => $request->fcm_id,

            'logintype'         => $request->logintype ?? $student->logintype,

            'is_email_verified' => $request->is_email_verified ?? $student->is_email_verified,

            'isActive'          => $request->status ?? $student->isActive,

            'notification'      => $request->notification ?? $student->notification,

            'subscription'      => $request->subscription ?? $student->subscription,

            'about_me'          => $request->about_me,

            'facebook_id'       => $request->facebook_id,

            'twiiter_id'        => $request->twiiter_id,

            'instagram_id'      => $request->instagram_id,

            'youtube_id'        => $request->youtube_id,

            'latitude'          => $request->latitude,

            'longitude'         => $request->longitude,

            'city'              => $request->city,

            'state'             => $request->state,

            'country'           => $request->country,

            'is_premium'        => $request->is_premium ?? $student->is_premium,

            'added_by'          => $request->added_by,

            'center_id'         => $request->center_id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */
        if ($request->filled('password')) {

            $student->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'student' => $student,
        ]);
    }

    /**
     * Remove specified student.
     */
    public function destroy(string $id)
    {
        $student = Customer::where('role', 'student')
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Delete Profile
        |--------------------------------------------------------------------------
        */
        if (
            $student->profile &&
            Storage::disk('public')->exists($student->profile)
        ) {

            Storage::disk('public')->delete($student->profile);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully',
        ]);
    }
}