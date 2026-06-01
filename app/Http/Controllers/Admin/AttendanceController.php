<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Customer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the attendance.
     */
    public function index()
    {
        $attendances = Attendance::with(['student', 'markedBy'])
            ->latest()
            ->get();

        $students = Customer::where('role','student')->get();

        return view('admin.attendance.index', compact(
            'attendances',
            'students'
        ));
    }

    /**
     * Store a newly created attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'      => 'required|exists:customers,id',
            'attendance_date' => 'required|date',
            'status'          => 'required|in:P,A,H,E,L',
            'remark'          => 'nullable|string',
        ]);

        // prevent duplicate attendance
        $exists = Attendance::where('student_id', $request->student_id)
            ->where('attendance_date', $request->attendance_date)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already marked for this student',
            ], 422);
        }

        $attendance = Attendance::create([
            'student_id'      => $request->student_id,
            'mark_by_id'      => Auth::id(),
            'attendance_date' => $request->attendance_date,
            'status'          => $request->status,
            'remark'          => $request->remark,
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Attendance marked successfully',
            'attendance' => $attendance->load(['student', 'markedBy']),
        ]);
    }

    /**
     * Display the specified attendance.
     */
    public function show(string $id)
    {
        $attendance = Attendance::with(['student', 'markedBy'])
            ->findOrFail($id);

        return response()->json([
            'success'    => true,
            'attendance' => $attendance,
        ]);
    }

    /**
     * Update the specified attendance.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id'      => 'required|exists:customers,id',
            'attendance_date' => 'required|date',
            'status'          => 'required|in:P,A,H,E,L',
            'remark'          => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($id);

        // prevent duplicate attendance
        $exists = Attendance::where('student_id', $request->student_id)
            ->where('attendance_date', $request->attendance_date)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already exists for this date',
            ], 422);
        }

        $attendance->update([
            'student_id'      => $request->student_id,
            'mark_by_id'      => Auth::id(),
            'attendance_date' => $request->attendance_date,
            'status'          => $request->status,
            'remark'          => $request->remark,
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Attendance updated successfully',
            'attendance' => $attendance->load(['student', 'markedBy']),
        ]);
    }

    /**
     * Remove the specified attendance.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attendance deleted successfully',
        ]);
    }
}
