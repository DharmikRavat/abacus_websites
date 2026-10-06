<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\StudentLead;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        StudentLead::create([
            'name' => $validated['name'],
            'mobile' => $validated['phone'],
            'email' => $validated['email'],
            'message' => $validated['message'],

            // Optional/default fields
            'region' => null,
            'follow_up_date' => null,
            'response' => null,
            'remark' => null,
            'demo' => 0,
            'admission' => 0,
            'teacher_name' => null,
            'feedback' => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Thank you! Your message has been submitted successfully.');
    }
}