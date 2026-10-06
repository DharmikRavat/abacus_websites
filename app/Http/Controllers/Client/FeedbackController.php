<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('client.feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        $user_id = session('student_id') ?? 1;

        Feedback::create([
            'user_id' => $user_id,
            'rating' => $request->rating,
            'message' => $request->message,
            'status' => 0,
            'date' => now()->format('Y-m-d')
        ]);

        return redirect()->route('feedbacks.create')->with('success', 'Thank you! Your feedback has been submitted successfully.');
    }
}
