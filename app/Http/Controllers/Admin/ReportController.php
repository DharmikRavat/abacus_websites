<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Attendance;
use App\Models\Customer;
use App\Models\User;

use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->report_type ?? 'attendance';

        $reports = collect();

        switch ($reportType) {

            // ─────────────────────────────
            // ATTENDANCE
            // ─────────────────────────────
            case 'attendance':

                $query = Attendance::with([
                    'student',
                    'markedBy'
                ]);

                // STATUS
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                // START DATE
                if ($request->filled('start_date')) {
                    $query->whereDate(
                        'attendance_date',
                        '>=',
                        $request->start_date
                    );
                }

                // END DATE
                if ($request->filled('end_date')) {
                    $query->whereDate(
                        'attendance_date',
                        '<=',
                        $request->end_date
                    );
                }

                $reports = $query
                    ->latest()
                    ->get();

            break;

            // ─────────────────────────────
            // STUDENTS
            // ─────────────────────────────
            case 'students':

                $query = Customer::query();

                if ($request->filled('status')) {

                    $query->where(
                        'status',
                        $request->status
                    );
                }

                $reports = $query
                    ->latest()
                    ->get();

            break;

            // ─────────────────────────────
            // TEACHERS
            // ─────────────────────────────
            case 'teachers':

                $query = User::where(
                    'role',
                    'teacher'
                );

                if ($request->filled('status')) {

                    $query->where(
                        'status',
                        $request->status
                    );
                }

                $reports = $query
                    ->latest()
                    ->get();

            break;

            default:

                $reports = collect();

            break;
        }

        return view(
            'admin.report.index',
            compact(
                'reports',
                'reportType'
            )
        );
    }

    // ─────────────────────────────────
    // EXPORT CSV
    // ─────────────────────────────────
    public function export(Request $request)
    {
        $reportType = $request->report_type ?? 'attendance';

        $fileName =
            $reportType . '_report_' . now()->timestamp . '.csv';

        $response = new StreamedResponse(function () use ($request, $reportType) {

            $handle = fopen('php://output', 'w');

            // ─────────────────────────
            // ATTENDANCE REPORT
            // ─────────────────────────
            if ($reportType == 'attendance') {

                fputcsv($handle, [
                    'Student',
                    'Status',
                    'Marked By',
                    'Date'
                ]);

                $reports = Attendance::with([
                    'student',
                    'markedBy'
                ])->latest()->get();

                foreach ($reports as $report) {

                    fputcsv($handle, [

                        $report->student->name ?? 'N/A',

                        match($report->status) {
                            'P' => 'Present',
                            'A' => 'Absent',
                            'L' => 'Leave',
                            default => 'Unknown'
                        },

                        $report->markedBy->name ?? 'Admin',

                        $report->attendance_date
                            ? date(
                                'd M Y',
                                strtotime($report->attendance_date)
                            )
                            : '-'
                    ]);
                }
            }

            // ─────────────────────────
            // STUDENT REPORT
            // ─────────────────────────
            elseif ($reportType == 'students') {

                fputcsv($handle, [
                    'Name',
                    'Phone',
                    'Email'
                ]);

                $reports = Customer::latest()->get();

                foreach ($reports as $report) {

                    fputcsv($handle, [

                        $report->name ?? 'N/A',
                        $report->phone ?? '-',
                        $report->email ?? '-'

                    ]);
                }
            }

            // ─────────────────────────
            // TEACHERS REPORT
            // ─────────────────────────
            elseif ($reportType == 'teachers') {

                fputcsv($handle, [
                    'Name',
                    'Email',
                    'Phone'
                ]);

                $reports = User::where(
                    'role',
                    'teacher'
                )->latest()->get();

                foreach ($reports as $report) {

                    fputcsv($handle, [

                        $report->name ?? 'N/A',
                        $report->email ?? '-',
                        $report->phone ?? '-'

                    ]);
                }
            }

            fclose($handle);

        });

        $response->headers->set(
            'Content-Type',
            'text/csv'
        );

        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="'.$fileName.'"'
        );

        return $response;
    }
}