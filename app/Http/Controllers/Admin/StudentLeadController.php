<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentLead;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class StudentLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = StudentLead::latest()->get();

        $students = Customer::where('role', 'student')
            ->orderBy('name')
            ->get();

        $teachers = User::where('role', 'teacher')
            ->orderBy('name')
            ->get();

        return view('admin.student-leads.index', compact('records', 'students','teachers'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string',

            'region' => 'nullable|string|max:100',
            'follow_up_date' => 'nullable|date',

            'response' => 'nullable|string|max:255',
            'remark' => 'nullable|string',

            'demo' => 'nullable|string|max:255',
            'admission' => 'nullable|string|max:255',

            'teacher_name' => 'nullable|string|max:255',
            'feedback' => 'nullable|string',
        ]);

        $record = StudentLead::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'message' => $request->message,

            'region' => $request->region,
            'follow_up_date' => $request->follow_up_date,

            'response' => $request->response,
            'remark' => $request->remark,

            'demo' => $request->demo,
            'admission' => $request->admission,

            'teacher_name' => $request->teacher_name,
            'feedback' => $request->feedback,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student lead created successfully.',
            'record' => $record,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = StudentLead::findOrFail($id);

        return response()->json([
            'success' => true,
            'record' => $record,
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string',

            'region' => 'nullable|string|max:100',
            'follow_up_date' => 'nullable|date',

            'response' => 'nullable|string|max:255',
            'remark' => 'nullable|string',

            'demo' => 'nullable|string|max:255',
            'admission' => 'nullable|string|max:255',

            'teacher_name' => 'nullable|string|max:255',
            'feedback' => 'nullable|string',
        ]);

        $record = StudentLead::findOrFail($id);

        $record->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'message' => $request->message,

            'region' => $request->region,
            'follow_up_date' => $request->follow_up_date,

            'response' => $request->response,
            'remark' => $request->remark,

            'demo' => $request->demo,
            'admission' => $request->admission,

            'teacher_name' => $request->teacher_name,
            'feedback' => $request->feedback,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student lead updated successfully.',
            'record' => $record,
        ]);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        $record = StudentLead::findOrFail($id);

        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student lead deleted successfully.',
        ]);
    }
}