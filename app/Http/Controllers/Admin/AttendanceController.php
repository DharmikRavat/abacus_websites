<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Customer;
use App\Models\Student;
use App\Models\StudentFeeRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

    public function monthlyReport(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Dates
        |--------------------------------------------------------------------------
        */
    
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);
    
        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
    
        /*
        |--------------------------------------------------------------------------
        | Only One Month
        |--------------------------------------------------------------------------
        */
    
        if (
            $startDate->month !== $endDate->month ||
            $startDate->year !== $endDate->year
        ) {
            abort(
                422,
                'Start date and end date must be from the same month.'
            );
        }
    
        /*
        |--------------------------------------------------------------------------
        | Generate Dates
        |--------------------------------------------------------------------------
        */
    
        $dates = collect(
            CarbonPeriod::create(
                $startDate->copy()->startOfDay(),
                $endDate->copy()->startOfDay()
            )
        );
    
        /*
        |--------------------------------------------------------------------------
        | Students
        |--------------------------------------------------------------------------
        */
    
        $students = Customer::where('role', 'student')
            ->orderBy('name')
            ->get();
    
        /*
        |--------------------------------------------------------------------------
        | Attendance Records
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Attendance table:
        |     student_id
        |
        | Customer table:
        |     id
        |     student_enrollment_id
        |
        */
    
        $attendanceRecords = Attendance::whereBetween(
            'attendance_date',
            [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
            ]
        )
        ->get()
        ->groupBy(function ($attendance) {
    
            return $attendance->student_id . '_' .
                Carbon::parse($attendance->attendance_date)
                    ->format('Y-m-d');
    
        });
    
        /*
        |--------------------------------------------------------------------------
        | Financial Year
        |--------------------------------------------------------------------------
        |
        | April 2026 - March 2027
        | = 2026-2027
        |
        */
    
        if ($startDate->month >= 4) {
    
            $financialYear =
                $startDate->year . '-' .
                ($startDate->year + 1);
    
        } else {
    
            $financialYear =
                ($startDate->year - 1) . '-' .
                $startDate->year;
        }
    
        /*
        |--------------------------------------------------------------------------
        | Current Month Column
        |--------------------------------------------------------------------------
        |
        | July    => july
        | August  => august
        | September => september
        |
        */
    
        $monthColumn = strtolower(
            $startDate->format('F')
        );
    
        /*
        |--------------------------------------------------------------------------
        | Fee Records
        |--------------------------------------------------------------------------
        |
        | student_fee_records.student_enrollment_id
        |
        | matches
        |
        | customers.student_enrollment_id
        |
        */
    
        $feeRecords = StudentFeeRecord::where(
            'financial_year',
            $financialYear
        )
        ->get()
        ->keyBy('student_enrollment_id');
    
        /*
        |--------------------------------------------------------------------------
        | Build Report
        |--------------------------------------------------------------------------
        */
    
        $reportStudents = [];
    
        foreach ($students as $student) {
    
            /*
            |--------------------------------------------------------------------------
            | Student Enrollment ID
            |--------------------------------------------------------------------------
            */
    
            $enrollmentId =
                $student->student_enrollment_id;
    
            /*
            |--------------------------------------------------------------------------
            | Find Fee Record
            |--------------------------------------------------------------------------
            */
    
            $feeRecord = $feeRecords->get(
                $enrollmentId
            );
    
            /*
            |--------------------------------------------------------------------------
            | Monthly Fee
            |--------------------------------------------------------------------------
            */
    
            $monthlyFee = 0;
    
            if ($feeRecord) {
    
                $monthlyFee = (float) (
                    $feeRecord->{$monthColumn} ?? 0
                );
            }
    
            /*
            |--------------------------------------------------------------------------
            | Attendance
            |--------------------------------------------------------------------------
            */
    
            $studentAttendance = [];
    
            $presentDays = 0;
            $absentDays  = 0;
            $holidayDays = 0;
            $leaveDays   = 0;
            $extraDays   = 0;
    
            foreach ($dates as $date) {
    
                $dateString = $date->format('Y-m-d');
    
                /*
                |--------------------------------------------------------------------------
                | Weekend
                |--------------------------------------------------------------------------
                */
    
                $isWeekend = $date->isWeekend();
    
                /*
                |--------------------------------------------------------------------------
                | Find Attendance
                |--------------------------------------------------------------------------
                |
                | attendance.student_id
                | matches
                | customer.id
                |
                */
    
                $key =
                    $student->id . '_' . $dateString;
    
                $attendance =
                    $attendanceRecords
                        ->get($key)
                        ?->first();
    
                $status =
                    $attendance?->status;
    
                /*
                |--------------------------------------------------------------------------
                | Count Attendance
                |--------------------------------------------------------------------------
                */
    
                if ($status === 'P') {
                    $presentDays++;
                }
    
                elseif ($status === 'A') {
                    $absentDays++;
                }
    
                elseif ($status === 'H') {
                    $holidayDays++;
                }
    
                elseif ($status === 'L') {
                    $leaveDays++;
                }
    
                elseif ($status === 'E') {
                    $extraDays++;
                }
    
                /*
                |--------------------------------------------------------------------------
                | Store Day
                |--------------------------------------------------------------------------
                */
    
                $studentAttendance[$dateString] = [
    
                    'status' =>
                        $status,
    
                    'remark' =>
                        $attendance?->remark,
    
                    'is_weekend' =>
                        $isWeekend,
    
                    'day' =>
                        $date->format('d'),
    
                    'day_name' =>
                        $date->format('D'),
    
                ];
            }
    
            /*
            |--------------------------------------------------------------------------
            | Monthly Classes
            |--------------------------------------------------------------------------
            |
            | Currently:
            |
            | Present days = classes attended
            |
            */
    
            $monthlyClasses = $presentDays;
    
            /*
            |--------------------------------------------------------------------------
            | Pay Per Class
            |--------------------------------------------------------------------------
            |
            | Example:
            |
            | Monthly fee = ₹1500
            | Classes = 20
            |
            | ₹1500 / 20 = ₹75
            |
            */
    
            $payPerClass = $monthlyClasses > 0
                ? round(
                    $monthlyFee / $monthlyClasses,
                    2
                )
                : 0;
    
            /*
            |--------------------------------------------------------------------------
            | Build Student Report
            |--------------------------------------------------------------------------
            */
    
            $reportStudents[] = [
    
                'student' =>
                    $student,
    
                'student_id' =>
                    $student->id,
    
                'enrollment_id' =>
                    $enrollmentId,
                    'joining_date' => $student->created_at,
    
                'attendance' =>
                    $studentAttendance,
    
                'monthly_fee' =>
                    $monthlyFee,
    
                'monthly_classes' =>
                    $monthlyClasses,
    
                'present_days' =>
                    $presentDays,
    
                'absent_days' =>
                    $absentDays,
    
                'holiday_days' =>
                    $holidayDays,
    
                'leave_days' =>
                    $leaveDays,
    
                'extra_days' =>
                    $extraDays,
    
                'pay_per_class' =>
                    $payPerClass,
    
                'pay_per_month' =>
                    $monthlyFee,
            ];
        }
    
        /*
        |--------------------------------------------------------------------------
        | Open Report
        |--------------------------------------------------------------------------
        */
    
        return view(
            'admin.attendance.monthly-report',
            compact(
                'startDate',
                'endDate',
                'dates',
                'reportStudents',
                'monthColumn',
                'financialYear'
            )
        );
    }

    /**
 * Generate Monthly Attendance PDF
 */
public function monthlyReportPdf(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
    ]);

    $startDate = Carbon::parse($request->start_date);
    $endDate   = Carbon::parse($request->end_date);

    /*
    |--------------------------------------------------------------------------
    | Make sure both dates are from the same month
    |--------------------------------------------------------------------------
    */

    if (
        $startDate->month !== $endDate->month ||
        $startDate->year !== $endDate->year
    ) {
        abort(422, 'Start date and end date must be from the same month.');
    }

    /*
    |--------------------------------------------------------------------------
    | Dates
    |--------------------------------------------------------------------------
    */

    $dates = collect(
        CarbonPeriod::create(
            $startDate->copy()->startOfDay(),
            $endDate->copy()->startOfDay()
        )
    );

    /*
    |--------------------------------------------------------------------------
    | Students
    |--------------------------------------------------------------------------
    */

    $students = Customer::where('role', 'student')
        ->orderBy('name')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Attendance Records
    |--------------------------------------------------------------------------
    */

    $attendanceRecords = Attendance::whereBetween(
        'attendance_date',
        [
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
        ]
    )
    ->get()
    ->groupBy(function ($attendance) {

        return $attendance->student_id . '_' .
            Carbon::parse($attendance->attendance_date)
                ->format('Y-m-d');

    });

    /*
    |--------------------------------------------------------------------------
    | Financial Year
    |--------------------------------------------------------------------------
    */

    if ($startDate->month >= 4) {

        $financialYear =
            $startDate->year . '-' .
            ($startDate->year + 1);

    } else {

        $financialYear =
            ($startDate->year - 1) . '-' .
            $startDate->year;
    }

    /*
    |--------------------------------------------------------------------------
    | Fee Month
    |--------------------------------------------------------------------------
    */

    $monthColumn = strtolower(
        $startDate->format('F')
    );

    /*
    |--------------------------------------------------------------------------
    | Fee Records
    |--------------------------------------------------------------------------
    */

    $feeRecords = StudentFeeRecord::where(
        'financial_year',
        $financialYear
    )
    ->get()
    ->keyBy('student_enrollment_id');

    /*
    |--------------------------------------------------------------------------
    | Build Report
    |--------------------------------------------------------------------------
    */

    $reportStudents = [];

    foreach ($students as $student) {

        /*
        |--------------------------------------------------------------------------
        | Get fee using student_enrollment_id
        |--------------------------------------------------------------------------
        */

        $feeRecord = $feeRecords->get(
            $student->student_enrollment_id
        );

        /*
        |--------------------------------------------------------------------------
        | Monthly Fee
        |--------------------------------------------------------------------------
        */

        $monthlyFee = 0;

        if ($feeRecord) {

            $monthlyFee = (float) (
                $feeRecord->{$monthColumn} ?? 0
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Attendance
        |--------------------------------------------------------------------------
        */

        $studentAttendance = [];

        $presentDays = 0;
        $absentDays  = 0;

        foreach ($dates as $date) {

            $dateString = $date->format('Y-m-d');

            $key =
                $student->id . '_' . $dateString;

            $attendance =
                $attendanceRecords
                    ->get($key)
                    ?->first();

            $status =
                $attendance?->status;

            /*
            |--------------------------------------------------------------------------
            | Count Attendance
            |--------------------------------------------------------------------------
            */

            if ($status === 'P') {
                $presentDays++;
            }

            if ($status === 'A') {
                $absentDays++;
            }

            $studentAttendance[$dateString] = [
                'status' => $status,
                'remark' => $attendance?->remark,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Monthly Classes
        |--------------------------------------------------------------------------
        */

        $monthlyClasses = $presentDays;

        /*
        |--------------------------------------------------------------------------
        | Pay Per Class
        |--------------------------------------------------------------------------
        */

        $payPerClass = $monthlyClasses > 0
            ? round($monthlyFee / $monthlyClasses)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Report Student
        |--------------------------------------------------------------------------
        */

        $reportStudents[] = [

            'student' => $student,

            'attendance' => $studentAttendance,

            'monthly_fee' => $monthlyFee,

            'monthly_classes' => $monthlyClasses,

            'present_days' => $presentDays,

            'absent_days' => $absentDays,

            'pay_per_class' => $payPerClass,

            'pay_per_month' => $monthlyFee,

            'enrollment_id' =>
                $student->student_enrollment_id,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Generate PDF
    |--------------------------------------------------------------------------
    */

    $pdf = Pdf::loadView(
        'admin.attendance.monthly-report-pdf',
        compact(
            'startDate',
            'endDate',
            'dates',
            'reportStudents',
            'monthColumn',
            'financialYear'
        )
    );

    /*
    |--------------------------------------------------------------------------
    | A4 Landscape
    |--------------------------------------------------------------------------
    */

    $pdf->setPaper('a4', 'landscape');

    /*
    |--------------------------------------------------------------------------
    | Open PDF in browser
    |--------------------------------------------------------------------------
    */

    return $pdf->stream(
        'monthly-attendance-' .
        $startDate->format('F-Y') .
        '.pdf'
    );
}
}
