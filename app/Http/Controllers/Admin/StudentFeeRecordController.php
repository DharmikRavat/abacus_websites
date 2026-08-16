<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\StudentFeeRecord;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentFeeRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = StudentFeeRecord::with('student')->latest()->get();
        $students = Customer::where('role', 'student')
        ->orderBy('name')
        ->get();

        return view('admin.student-fees.index', compact('records','students'));
    }
  
    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_enrollment_id' => 'required',
            'financial_year' => 'required|string|max:20',

            'april' => 'nullable|numeric',
            'may' => 'nullable|numeric',
            'june' => 'nullable|numeric',
            'july' => 'nullable|numeric',
            'august' => 'nullable|numeric',
            'september' => 'nullable|numeric',
            'october' => 'nullable|numeric',
            'november' => 'nullable|numeric',
            'december' => 'nullable|numeric',
            'january' => 'nullable|numeric',
            'february' => 'nullable|numeric',
            'march' => 'nullable|numeric',

            'remark' => 'nullable|string',
        ]);

        $record = StudentFeeRecord::create([
            'student_enrollment_id' => $request->student_enrollment_id,
            'financial_year' => $request->financial_year,

            'april' => $request->april ?? 0,
            'may' => $request->may ?? 0,
            'june' => $request->june ?? 0,
            'july' => $request->july ?? 0,
            'august' => $request->august ?? 0,
            'september' => $request->september ?? 0,
            'october' => $request->october ?? 0,
            'november' => $request->november ?? 0,
            'december' => $request->december ?? 0,
            'january' => $request->january ?? 0,
            'february' => $request->february ?? 0,
            'march' => $request->march ?? 0,

            'total_amount' =>
                ($request->april ?? 0) +
                ($request->may ?? 0) +
                ($request->june ?? 0) +
                ($request->july ?? 0) +
                ($request->august ?? 0) +
                ($request->september ?? 0) +
                ($request->october ?? 0) +
                ($request->november ?? 0) +
                ($request->december ?? 0) +
                ($request->january ?? 0) +
                ($request->february ?? 0) +
                ($request->march ?? 0),

            'remark' => $request->remark,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fee record created successfully.',
            'record' => $record,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = StudentFeeRecord::findOrFail($id);

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
            'student_enrollment_id' => 'required',
            'financial_year' => 'required|string|max:20',
            'april' => 'nullable|numeric',
            'may' => 'nullable|numeric',
            'june' => 'nullable|numeric',
            'july' => 'nullable|numeric',
            'august' => 'nullable|numeric',
            'september' => 'nullable|numeric',
            'october' => 'nullable|numeric',
            'november' => 'nullable|numeric',
            'december' => 'nullable|numeric',
            'january' => 'nullable|numeric',
            'february' => 'nullable|numeric',
            'march' => 'nullable|numeric',
            'remark' => 'nullable|string',
        ]);

        $record = StudentFeeRecord::findOrFail($id);

        $record->update([
            'student_enrollment_id' => $request->student_enrollment_id,
            'financial_year' => $request->financial_year,

            'april' => $request->april ?? 0,
            'may' => $request->may ?? 0,
            'june' => $request->june ?? 0,
            'july' => $request->july ?? 0,
            'august' => $request->august ?? 0,
            'september' => $request->september ?? 0,
            'october' => $request->october ?? 0,
            'november' => $request->november ?? 0,
            'december' => $request->december ?? 0,
            'january' => $request->january ?? 0,
            'february' => $request->february ?? 0,
            'march' => $request->march ?? 0,

            'total_amount' =>
                ($request->april ?? 0) +
                ($request->may ?? 0) +
                ($request->june ?? 0) +
                ($request->july ?? 0) +
                ($request->august ?? 0) +
                ($request->september ?? 0) +
                ($request->october ?? 0) +
                ($request->november ?? 0) +
                ($request->december ?? 0) +
                ($request->january ?? 0) +
                ($request->february ?? 0) +
                ($request->march ?? 0),

            'remark' => $request->remark,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fee record updated successfully.',
            'record' => $record,
        ]);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        $record = StudentFeeRecord::findOrFail($id);

        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fee record deleted successfully.',
        ]);
    }
}