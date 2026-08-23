<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\StudentCertification;
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
        ->with('certifications')
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

            'student_enrollment_id' => 'nullable|string|max:50',
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

            'student_enrollment_id' => $request->student_enrollment_id,
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
            'student_enrollment_id' => 'nullable|string|max:50',
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

            'student_enrollment_id' => $request->student_enrollment_id,
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

    /*
    |--------------------------------------------------------------------------
    | SAVE / UPDATE CERTIFICATION
    |--------------------------------------------------------------------------
    */

    if ($request->boolean('save_certification')) {

        $request->validate([

            'student_name' => 'nullable|string|max:255',

            'parents_name' => 'nullable|string|max:255',

            'mobile_no' => 'nullable|string|max:20',

            'exam_date' => 'nullable|date',

            'level' => 'nullable|string|max:255',

            'score' => 'nullable|numeric',

            'result' => 'nullable|string|max:255',

            'address' => 'nullable|string',

            'receiver_name' => 'nullable|string|max:255',

            'receiver_contact' => 'nullable|string|max:255',

            'abacus_trainer_name' => 'nullable|string|max:255',

            'certificate_date' => 'nullable|date',

            'dispatched_date' => 'nullable|date',

            'dispatched_id' => 'nullable|string|max:255',

            'received_date' => 'nullable|date',

            'remark' => 'nullable|string',

            'address_image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'certificate_image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'certification_id' => 'nullable|integer',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Find Existing Certification / Create New
        |--------------------------------------------------------------------------
        */

        if ($request->filled('certification_id')) {

            $certification = StudentCertification::where(
                'id',
                $request->certification_id
            )
                ->where(
                    'student_id',
                    $student->id
                )
                ->firstOrFail();

        } else {

            $certification = new StudentCertification();

            $certification->student_id = $student->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Certification Details
        |--------------------------------------------------------------------------
        */

        $certification->student_name =
            $request->student_name ?: $student->name;

        $certification->parents_name =
            $request->parents_name;

        $certification->mobile_no =
            $request->mobile_no ?: $student->mobile;

        $certification->exam_date =
            $request->exam_date;

        $certification->level =
            $request->level;

        $certification->score =
            $request->score;

        $certification->result =
            $request->result;

        $certification->address =
            $request->address;

        $certification->receiver_name =
            $request->receiver_name;

        $certification->receiver_contact =
            $request->receiver_contact;

        $certification->abacus_trainer_name =
            $request->abacus_trainer_name;

        $certification->certificate_date =
            $request->certificate_date;

        $certification->dispatched_date =
            $request->dispatched_date;

        $certification->dispatched_id =
            $request->dispatched_id;

        $certification->received_date =
            $request->received_date;

        $certification->remark =
            $request->remark;


        /*
        |--------------------------------------------------------------------------
        | Create Directory
        |--------------------------------------------------------------------------
        */

        $uploadPath = public_path('student-certificates');

        if (!is_dir($uploadPath)) {

            mkdir(
                $uploadPath,
                0755,
                true
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Address Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('address_image')) {

            /*
            | Delete old address image
            */

            if (
                $certification->address_image &&
                file_exists(
                    public_path($certification->address_image)
                )
            ) {

                unlink(
                    public_path($certification->address_image)
                );
            }


            /*
            | Upload new image
            */

            $file = $request->file('address_image');

            $filename =
                'address_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $file->getClientOriginalExtension();

            $file->move(
                $uploadPath,
                $filename
            );

            $certification->address_image =
                'student-certificates/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | Certificate Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('certificate_image')) {

            /*
            | Delete old certificate image
            */

            if (
                $certification->certificate_image &&
                file_exists(
                    public_path($certification->certificate_image)
                )
            ) {

                unlink(
                    public_path($certification->certificate_image)
                );
            }


            /*
            | Upload new image
            */

            $file = $request->file('certificate_image');

            $filename =
                'certificate_' .
                time() .
                '_' .
                uniqid() .
                '.' .
                $file->getClientOriginalExtension();

            $file->move(
                $uploadPath,
                $filename
            );

            $certification->certificate_image =
                'student-certificates/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | Save Certification
        |--------------------------------------------------------------------------
        */

        $certification->save();


        /*
        |--------------------------------------------------------------------------
        | Get All Certifications
        |--------------------------------------------------------------------------
        */

        $certifications =
            StudentCertification::where(
                'student_id',
                $student->id
            )
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'message' =>
                $request->filled('certification_id')
                    ? 'Certification updated successfully'
                    : 'Certification added successfully',

            'certification' =>
                $certification,

            'certifications' =>
                $certifications,

        ]);
    }

        /*
        |--------------------------------------------------------------------------
        | NORMAL STUDENT UPDATE
        |--------------------------------------------------------------------------
        */
    
        // Your existing student update code continues here...
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
            'student_enrollment_id' => 'nullable|string|max:50',
            
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
            'student_enrollment_id' => $request->student_enrollment_id,
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