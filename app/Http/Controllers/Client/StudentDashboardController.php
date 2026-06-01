<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    // 
    public function index()
    {
        $students = Customer::where('role','student')->get();
        return view('client.dashboard.index', compact('students'));
    }

    // Show form (optional)
    public function create()
    {
        return view('client.dashboard.user.add');
    }

    public function choose_user()
    {
        return view('client.dashboard.user.choose');
    }
    // Free Practice Test
    public function free_practice()
    {
        return view('client.dashboard.exam.practice');
    }
 
    public function get_added_user()
    {
        // Get student_id from session
        $user_id = session('student_id');
    
        // Check user exists
        $user = Customer::find($user_id);
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
    
        // Get logged-in user + added customers
        $students = Customer::select('*')
            ->selectRaw("'owner' as record_type")
            ->where('id', $user_id)
    
            ->unionAll(
                Customer::select('*')
                    ->selectRaw("'customer' as record_type")
                    ->where('added_by', $user_id)
            )
            ->orderBy('id', 'DESC')
            ->get();
    
        return view('client.dashboard.user.choose', compact('students'));
    }


    // Store new student
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|min:6',
            'mobile'   => 'required|string|max:15',
            'address'  => 'nullable|string',
            'city'     => 'nullable|string',
            'state'    => 'nullable|string',
            'country'  => 'nullable|string',
        ]);

        $student = Customer::create([
            'name'      => $request->name,
            'slug_id'   => Str::slug($request->name),
            'auth_id'   => Str::uuid(),
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'mobile'    => $request->mobile,
            'address'   => $request->address,
            'city'      => $request->city,
            'state'     => $request->state,
            'country'   => $request->country,

            'role'      => 'student',
            'isActive'  => 1,
            'is_email_verified' => 0,
        ]);

        return redirect()->back()->with('success', 'Student added successfully!');
    }
}
