<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::latest()->get();

        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'message' => 'required|string',
            'rating'  => 'required|integer|min:1|max:5',
            'status'  => 'required|boolean',
            'date'    => 'required|date',
        ]);

        $feedback = Feedback::create([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'rating'  => $request->rating,
            'status'  => $request->status,
            'date'    => $request->date,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Feedback created successfully',
            'feedback' => $feedback,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feedback = Feedback::findOrFail($id);

        return response()->json([
            'success'  => true,
            'feedback' => $feedback,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'message' => 'required|string',
            'rating'  => 'required|integer|min:1|max:5',
            'status'  => 'required|boolean',
            'date'    => 'required|date',
        ]);

        $feedback = Feedback::findOrFail($id);

        $feedback->update([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'rating'  => $request->rating,
            'status'  => $request->status,
            'date'    => $request->date,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Feedback updated successfully',
            'feedback' => $feedback,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Feedback deleted successfully',
        ]);
    }
}