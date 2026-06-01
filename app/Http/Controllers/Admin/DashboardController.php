<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Counts
        $totalStudents   = Customer::count();
        $totalTeachers   = User::where('role', 'teacher')->count();
        $totalAttendance = Attendance::count();
    
        // Today's Attendance
        $presentToday = Attendance::whereDate('attendance_date', today())
            ->where('status', 'P')
            ->count();
    
        $absentToday = Attendance::whereDate('attendance_date', today())
            ->where('status', 'A')
            ->count();
    
        $leaveToday = Attendance::whereDate('attendance_date', today())
            ->where('status', 'L')
            ->count();
    
        // Overall Attendance Counts
        $presentCount = Attendance::where('status', 'P')->count();
        $absentCount  = Attendance::where('status', 'A')->count();
        $leaveCount   = Attendance::where('status', 'L')->count();
    
        // Attendance Percentage
        $attendancePercentage = $totalAttendance > 0
            ? round(($presentCount / $totalAttendance) * 100, 2)
            : 0;
    
        // Current Month Attendance
        $monthlyAttendance = Attendance::whereMonth(
                'attendance_date',
                now()->month
            )
            ->whereYear(
                'attendance_date',
                now()->year
            )
            ->count();
    
        // Recent Attendance
        $recentAttendances = Attendance::with([
                'student',
                'markedBy'
            ])
            ->latest()
            ->take(10)
            ->get();
    
        // Attendance Chart (Last 7 Days)
        $attendanceChartLabels = [];
        $attendanceChartData   = [];
    
        for ($i = 6; $i >= 0; $i--) {
    
            $date = Carbon::now()->subDays($i);
    
            $attendanceChartLabels[] = $date->format('d M');
    
            $attendanceChartData[] = Attendance::whereDate(
                    'attendance_date',
                    $date
                )->count();
        }
    
        return view('admin.dashboard.index', compact(
    
            'totalStudents',
            'totalTeachers',
            'totalAttendance',
    
            'presentToday',
            'absentToday',
            'leaveToday',
    
            'presentCount',
            'absentCount',
            'leaveCount',
    
            'attendancePercentage',
            'monthlyAttendance',
    
            'recentAttendances',
    
            'attendanceChartLabels',
            'attendanceChartData'
        ));
    }
}