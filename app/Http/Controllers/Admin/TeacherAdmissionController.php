<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherAdmission;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TeacherAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = TeacherAdmission::latest()->get();
        $teachers = User::where('role', 'teacher')
        ->orderBy('name')
        ->get();


        return view(
            'admin.teacher-fees.index',
            compact('records','teachers')
        );
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|string|max:255|unique:teacher_admissions,teacher_id',
            'teacher_name' => 'required|string|max:255',
            'financial_year' => 'required|string|max:20',
            'mobile_no' => 'required|string|max:20',

            'trainer_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'region' => 'nullable|string|max:255',

            'admission_date' => 'nullable|date',

            'junior_amount' => 'nullable|numeric|min:0',

            'level_01_amount' => 'nullable|numeric|min:0',
            'level_02_amount' => 'nullable|numeric|min:0',
            'level_03_amount' => 'nullable|numeric|min:0',
            'level_04_amount' => 'nullable|numeric|min:0',
            'level_05_amount' => 'nullable|numeric|min:0',
            'level_06_amount' => 'nullable|numeric|min:0',
            'level_07_amount' => 'nullable|numeric|min:0',
            'level_08_amount' => 'nullable|numeric|min:0',
            'level_09_amount' => 'nullable|numeric|min:0',
            'level_10_amount' => 'nullable|numeric|min:0',

            'remark' => 'nullable|string',
        ]);

        $record = TeacherAdmission::create([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => $request->teacher_name,
            'financial_year' => $request->financial_year,
            'mobile_no' => $request->mobile_no,

            'trainer_name' => $request->trainer_name,
            'address' => $request->address,
            'region' => $request->region,

            'admission_date' => $request->admission_date,

            'junior_amount' => $request->junior_amount ?? 0,

            'level_01_amount' => $request->level_01_amount ?? 0,
            'level_02_amount' => $request->level_02_amount ?? 0,
            'level_03_amount' => $request->level_03_amount ?? 0,
            'level_04_amount' => $request->level_04_amount ?? 0,
            'level_05_amount' => $request->level_05_amount ?? 0,
            'level_06_amount' => $request->level_06_amount ?? 0,
            'level_07_amount' => $request->level_07_amount ?? 0,
            'level_08_amount' => $request->level_08_amount ?? 0,
            'level_09_amount' => $request->level_09_amount ?? 0,
            'level_10_amount' => $request->level_10_amount ?? 0,

            'remark' => $request->remark,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher admission created successfully.',
            'record' => $record,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = TeacherAdmission::findOrFail($id);

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
            'teacher_id' => 'required|string|max:255|unique:teacher_admissions,teacher_id,' . $id,
            'teacher_name' => 'required|string|max:255',
            'financial_year' => 'required|string|max:20',
            'mobile_no' => 'required|string|max:20',

            'trainer_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'region' => 'nullable|string|max:255',

            'admission_date' => 'nullable|date',

            'junior_amount' => 'nullable|numeric|min:0',

            'level_01_amount' => 'nullable|numeric|min:0',
            'level_02_amount' => 'nullable|numeric|min:0',
            'level_03_amount' => 'nullable|numeric|min:0',
            'level_04_amount' => 'nullable|numeric|min:0',
            'level_05_amount' => 'nullable|numeric|min:0',
            'level_06_amount' => 'nullable|numeric|min:0',
            'level_07_amount' => 'nullable|numeric|min:0',
            'level_08_amount' => 'nullable|numeric|min:0',
            'level_09_amount' => 'nullable|numeric|min:0',
            'level_10_amount' => 'nullable|numeric|min:0',

            'remark' => 'nullable|string',
        ]);

        $record = TeacherAdmission::findOrFail($id);

        $record->update([
            'teacher_id' => $request->teacher_id,
            'teacher_name' => $request->teacher_name,
            'financial_year' => $request->financial_year,
            'mobile_no' => $request->mobile_no,

            'trainer_name' => $request->trainer_name,
            'address' => $request->address,
            'region' => $request->region,

            'admission_date' => $request->admission_date,

            'junior_amount' => $request->junior_amount ?? 0,

            'level_01_amount' => $request->level_01_amount ?? 0,
            'level_02_amount' => $request->level_02_amount ?? 0,
            'level_03_amount' => $request->level_03_amount ?? 0,
            'level_04_amount' => $request->level_04_amount ?? 0,
            'level_05_amount' => $request->level_05_amount ?? 0,
            'level_06_amount' => $request->level_06_amount ?? 0,
            'level_07_amount' => $request->level_07_amount ?? 0,
            'level_08_amount' => $request->level_08_amount ?? 0,
            'level_09_amount' => $request->level_09_amount ?? 0,
            'level_10_amount' => $request->level_10_amount ?? 0,

            'remark' => $request->remark,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teacher admission updated successfully.',
            'record' => $record,
        ]);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        $record = TeacherAdmission::findOrFail($id);

        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teacher admission deleted successfully.',
        ]);
    }
}