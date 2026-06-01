<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('student_id')) {
            return redirect('/');
        }

        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        // Fetch student from customers table
        $student = DB::table('customers')
            ->where('email', $request->email)
            ->where('role', 'student')   // IMPORTANT from your data
            ->first();

        if (!$student) {
            return back()->with('error', 'Student not found.');
        }

        // Check password
        $isPasswordValid = Hash::check($request->password, $student->password);

        if (!$isPasswordValid) {
            return back()->with('error', 'Invalid password.');
        }

        // Optional: check active flag (you have multiple 0/1 fields, adjust if needed)
        // Example: if column is "status" or "is_active"
        if (isset($student->status) && $student->status == 0) {
            return back()->with('error', 'Account is inactive.');
        }

        // Store session
        session([
            'student_id'    => $student->id,
            'student_name'  => $student->name,
            'student_email' => $student->email,
            'student_role'  => $student->role,
        ]);

        return redirect('/');
    }
    // Direct Login 
    public function directLogin(Request $request)
{
    $request->validate([
        'student_id' => 'required',
        'password'   => 'required',
    ]);

    // Get student
    $student = DB::table('customers')
        ->where('id', $request->student_id)
        ->where('role', 'student')
        ->first();

    if (!$student) {
        return back()->with('error', 'Student not found.');
    }

    // Verify password
    if (!Hash::check($request->password, $student->password)) {
        return back()->with('error', 'Invalid password.');
    }

    // Create session
    session([
        'student_id'    => $student->id,
        'student_name'  => $student->name,
        'student_email' => $student->email,
        'student_role'  => $student->role,
    ]);

    return redirect('/')
        ->with('success', 'Logged in successfully as '.$student->name);
}

    public function logout(Request $request)
    {
        session()->forget([
            'student_id',
            'student_name',
            'student_email',
            'student_role'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}