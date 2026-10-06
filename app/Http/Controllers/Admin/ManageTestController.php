<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Question;
use App\Models\QuestionType;
use App\Models\TestSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageTestController extends Controller
{
    /* =========================
       LIST ALL SCHEDULES
    ========================== */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $schedules = TestSchedule::latest()->get()->map(function ($schedule) {

                return [
                    'id'                   => $schedule->id,
                    'test_type'            => $schedule->test_type,
                    'exam_level'           => $schedule->exam_level,
                    'schedule_date'        => $schedule->schedule_date,
                    'schedule_exam_type'   => $schedule->schedule_exam_type,
                    'no_of_questions'      => $schedule->no_of_questions,
                    'schedule_time'        => $schedule->schedule_time,
                    'schedule_password'    => $schedule->schedule_password,
                    'result_declare_date'  => $schedule->result_declare_date,
                    'created_at'           => $schedule->created_at,
                ];
            });

            return response()->json($schedules);
        }

        $schedules = TestSchedule::latest()->get();

        return view('admin.manage-tests.index', compact('schedules'));
    }
    /* =========================
       CREATE SCHEDULE
    ========================== */
    public function store(Request $request)
    {
        $minutes = (int) $request->schedule_time;
        $hours = floor($minutes / 60);
        $rem_minutes = $minutes % 60;
        $formatted_time = sprintf('%02d:%02d:00', $hours, $rem_minutes);

        $schedule = TestSchedule::create([
            'test_type' => $request->test_type,
            'exam_level' => $request->exam_level,
            'schedule_date' => $request->schedule_date,
            'schedule_exam_type' => $request->schedule_exam_type,
            'no_of_questions' => $request->no_of_questions,
            'schedule_time' => $formatted_time,
            'schedule_password' => $request->schedule_password,
            'result_declare_date' => $request->result_declare_date,
        ]);

        return response()->json([
            'message' => 'Schedule added successfully',
            'data' => $schedule
        ]);
    }

    /* =========================
       SHOW SINGLE SCHEDULE
    ========================== */
    public function show(TestSchedule $manage_test)
    {
        return response()->json($manage_test);
    }

    /* =========================
       UPDATE SCHEDULE
    ========================== */
    public function update(Request $request, TestSchedule $manage_test)
    {
        $minutes = (int) $request->schedule_time;
        $hours = floor($minutes / 60);
        $rem_minutes = $minutes % 60;
        $formatted_time = sprintf('%02d:%02d:00', $hours, $rem_minutes);

        $manage_test->update([
            'test_type' => $request->test_type,
            'exam_level' => $request->exam_level,
            'schedule_date' => $request->schedule_date,
            'schedule_exam_type' => $request->schedule_exam_type,
            'no_of_questions' => $request->no_of_questions,
            'schedule_time' => $formatted_time,
            'schedule_password' => $request->schedule_password,
            'result_declare_date' => $request->result_declare_date,
        ]);

        return response()->json([
            'message' => 'Schedule updated successfully',
            'data' => $manage_test
        ]);
    }

    /* =========================
       DELETE SCHEDULE
    ========================== */
    public function destroy(TestSchedule $manage_test)
    {
        $manage_test->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule deleted successfully'
        ]);
    }
}
