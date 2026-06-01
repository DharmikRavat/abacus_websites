<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return view('admin.auth.test');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
    
            $user = Auth::user();
    
            if (!in_array($user->role, ['admin', 'teacher'])) {
    
                Auth::logout();
    
                return back()->with('error', 'Unauthorized access.');
            }
    
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
    
            if ($user->role === 'teacher') {
                return redirect('/teacher/dashboard');
            }
        }
    
        return back()->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
