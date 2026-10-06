<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    //
    public function index()
    {
        $students = Customer::where('role','student')->get();
        return view('client.dashboard.index', compact('students'));
    }

    public function create()
    {
        $lastStudent = Customer::whereNotNull('student_enrollment_id')
                                ->orderBy('id', 'desc')
                                ->first();

        $year = date('Y');
        $prefix = "IAA{$year}S";
        $nextId = $prefix . "0001";

        if ($lastStudent && $lastStudent->student_enrollment_id) {
            $lastId = $lastStudent->student_enrollment_id;
            if (preg_match('/(IAA\d{4}S)(\d+)/', $lastId, $matches)) {
                $lastPrefix = $matches[1];
                $lastNum = (int)$matches[2];
                if ($lastPrefix === $prefix) {
                    $nextNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
                    $nextId = $prefix . $nextNum;
                }
            }
        }

        $nextEnrollmentId = $nextId;
        $centers = \App\Models\Customer::where('role', 'center')->get(); // Assuming centers might be roles, or empty if not used

        return view('client.dashboard.user.add', compact('nextEnrollmentId', 'centers'));
    }

    public function choose_user()
    {
        return view('client.dashboard.user.choose');
    }
    public function free_practice()
    {
        $modes = \App\Models\ExamMode::where('status', 1)->get();
        $levels = \App\Models\ExamLevel::where('is_active', 1)->get();
        $durations = \App\Models\ExamDuration::where('status', 1)->get();

        return view('client.dashboard.exam.practice', compact('modes', 'levels', 'durations'));
    }
    public function get_added_user()
    {
        // Get student_id from session
        $user_id = session('student_id');

        // Check user exists
        $user = Customer::find($user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Get logged-in user + added customers
        $students = Customer::select('*')
            ->selectRaw("'owner' as record_type")
            ->where('id', $user_id)

            ->unionAll(
                Customer::select('*')
                    ->selectRaw("'customer' as record_type")
                    ->where('added_by', $user_id)
            )
            ->orderBy('id', 'DESC')
            ->get();

        return view('client.dashboard.user.choose', compact('students'));
    }


    // Store new student
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|min:6',
            'mobile'   => 'required|string|max:15',
            'address'  => 'nullable|string',
            'city'     => 'nullable|string',
            'state'    => 'nullable|string',
            'country'  => 'nullable|string',
        ]);

        $profilePath = null;
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('students', 'public');
        }

        $student = Customer::create([
            'name'      => $request->name,
            'slug_id'   => Str::slug($request->name),
            'auth_id'   => Str::uuid(),
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'mobile'    => $request->mobile,
            'profile'   => $profilePath,
            'address'   => $request->address,
            'city'      => $request->city,
            'state'     => $request->state,
            'country'   => $request->country,
            'student_enrollment_id' => $request->student_enrollment_id,

            'role'      => 'student',
            'isActive'  => 1,
            'is_email_verified' => 0,
            'added_by'  => session('student_id'),
        ]);

        return redirect()->back()->with('success', 'Student added successfully!');
    }

    public function submit_score(Request $request)
    {
        $activeScoreId = session('active_score_id');

        $isPending = false;
        $resultAvailableAt = null;

        if ($activeScoreId) {
            $scoreRecord = \Illuminate\Support\Facades\DB::table('scores')->where('id', $activeScoreId)->first();

            $updateData = [
                'total' => $request->total,
                'correct' => $request->correct,
                'wrong' => $request->wrong,
                'skipped' => $request->skipped,
                'is_visible' => 1,
                'time' => $request->time_spent ?? 0,
                'updated_at' => now(),
            ];

            if ($scoreRecord && $scoreRecord->exam_type === 'exam' && $request->schedule_id) {
                $schedule = \App\Models\TestSchedule::find($request->schedule_id);
                if ($schedule && $schedule->result_declare_date) {
                    $updateData['result_available_at'] = $schedule->result_declare_date;
                    $isPending = true;
                    $resultAvailableAt = \Carbon\Carbon::parse($schedule->result_declare_date)->format('d F Y \a\t h:i A');
                }
            }

            \Illuminate\Support\Facades\DB::table('scores')
                ->where('id', $activeScoreId)
                ->update($updateData);

            session()->forget('active_score_id');
        } else {
            $user_id = session('student_id');
            if (!$user_id) {
                $user_id = \App\Models\Customer::first()->id ?? 1;
            }

            // SECURITY: Never trust exam_type from the browser.
            // If no active_score_id exists, force it to 'practice'.
            $examType = 'practice';

            \Illuminate\Support\Facades\DB::table('scores')->insert([
                'score_unique_id' => \Illuminate\Support\Str::uuid(),
                'exam_type' => $examType,
                'user_id' => $user_id,
                'center_id' => 1,
                'total' => $request->total,
                'correct' => $request->correct,
                'wrong' => $request->wrong,
                'skipped' => $request->skipped,
                'is_visible' => 1,
                'time' => $request->time_spent ?? 0,
                'mode_id' => $request->mode_id,
                'exam_level_id' => $request->exam_level_id,
                'duration_id' => $request->duration_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'is_pending' => $isPending,
            'result_available_at' => $resultAvailableAt
        ]);
    }

    public function assessment_form($type)
    {
        $user_id = session('student_id');
        $user = \App\Models\Customer::find($user_id);

        $centers = \Illuminate\Support\Facades\DB::table('centers')->get();
        $modes = \App\Models\ExamMode::where('status', 1)->get();
        $levels = \App\Models\ExamLevel::where('is_active', 1)->get();

        return view('client.dashboard.exam.auth_form', compact('type', 'user', 'centers', 'modes', 'levels'));
    }

    public function get_level(Request $request)
    {
        $password = $request->password;
        $examType = $request->exam_type;
        $scheduleTestType = $request->schedule_test_type;

        $scheduleType = $examType === 'test' ? $scheduleTestType . '_test' : $scheduleTestType;

        $schedule = \App\Models\TestSchedule::where('schedule_password', $password)
            ->where('schedule_exam_type', $scheduleType)
            ->first();

        if ($schedule) {
            $levelStr = str_replace('Level ', '', $schedule->exam_level);
            $level = \App\Models\ExamLevel::where('level', $levelStr)->first();

            if ($level) {
                return response()->json(['success' => true, 'level_id' => $level->id]);
            }
        }

        return response()->json(['success' => false]);
    }

    public function start_assessment(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'student_name' => 'required',
            'center_id' => 'required',
            'password' => 'required',
            'schedule_test_type' => 'required',
            'level_id' => 'required',
            'exam_type' => 'required',
            'exam_selfie' => 'required_if:exam_type,exam'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user_id = session('student_id');
        $user = \App\Models\Customer::find($user_id);

        if ($user && strtolower(trim($request->student_name)) !== strtolower(trim($user->name))) {
            return response()->json(['success' => false, 'message' => 'The entered name does not match your registered profile name.']);
        }

        $level = \App\Models\ExamLevel::find($request->level_id);

        $scheduleType = $request->exam_type === 'test' ? $request->schedule_test_type . '_test' : $request->schedule_test_type;
        $schedule = \App\Models\TestSchedule::where('exam_level', 'Level ' . $level->level)
            ->where('schedule_exam_type', $scheduleType)
            ->latest()
            ->first();

        if (!$schedule) {
            $formattedType = ucwords(str_replace('_', ' ', $request->schedule_test_type));
            return response()->json(['success' => false, 'message' => 'No ' . $formattedType . ' is currently scheduled for this level.']);
        }

        // Prevent taking the test a second time if already completed
        $alreadyCompleted = \Illuminate\Support\Facades\DB::table('scores')
            ->where('user_id', $user_id)
            ->where('exam_type', $request->exam_type)
            ->where('schedule_test_type', $request->schedule_test_type)
            ->where('exam_level_id', $request->level_id)
            ->where('created_at', '>=', $schedule->created_at)
            ->where(function($query) {
                $query->where('time', '>', 0)->orWhere('total', '>', 0);
            })
            ->exists();

        if ($alreadyCompleted) {
            return response()->json(['success' => false, 'message' => 'You have already completed this ' . $request->exam_type . '. Multiple attempts are not allowed.']);
        }

        if ($schedule && $schedule->schedule_password) {
            if ($request->password !== $schedule->schedule_password) {
                return response()->json(['success' => false, 'message' => 'Incorrect password for this scheduled test.']);
            }
        } else {
            $user = \App\Models\Customer::find($user_id);

            if ($user && $user->password) {
                $isMatch = false;
                try {
                    $isMatch = \Illuminate\Support\Facades\Hash::check($request->password, $user->password);
                } catch (\Exception $e) {
                    $isMatch = false;
                }

                if (!$isMatch && $request->password !== $user->password) {
                    return response()->json(['success' => false, 'message' => 'Incorrect password.']);
                }
            } elseif ($request->password !== '123456') { // Fallback for dummy users
                return response()->json(['success' => false, 'message' => 'Incorrect password.']);
            }
        }

        $level = \App\Models\ExamLevel::find($request->level_id);
        $mode = \App\Models\ExamMode::where('name', ucfirst($level->difficulty))->first();
        $mode_id = $mode ? $mode->id : 1;

        $timerMinutes = 5;
        $timerSeconds = 0;

        if ($schedule && $schedule->schedule_time) {
            $timeParts = explode(':', $schedule->schedule_time);
            if (count($timeParts) == 3) {
                // schedule_time format: HH:MM:SS
                $timerMinutes = ((int)$timeParts[0] * 60) + (int)$timeParts[1];
                $timerSeconds = (int)$timeParts[2];
            } else {
                $timerMinutes = (int)$schedule->schedule_time;
                $timerSeconds = 0;
            }
        }

        $durationId = \App\Models\ExamDuration::where('duration_minutes', $timerMinutes)->value('id') ?? 2;

        $scoreId = \Illuminate\Support\Facades\DB::table('scores')->insertGetId([
            'score_unique_id' => \Illuminate\Support\Str::uuid(),
            'exam_type' => $request->exam_type,
            'user_id' => $user_id ?? 1,
            'center_id' => $request->center_id,
            'exam_selfie' => $request->exam_selfie,
            'schedule_test_type' => $request->schedule_test_type,
            'mode_id' => $mode_id,
            'exam_level_id' => $request->level_id,
            'duration_id' => $durationId,
            'total' => 0,
            'correct' => 0,
            'wrong' => 0,
            'skipped' => 0,
            'is_visible' => 1,
            'time' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session(['active_score_id' => $scoreId]);

        return response()->json([
            'success' => true,
            'message' => 'Exam started successfully.',
            'redirect_url' => route('exam-sheet', [
                'mode' => $mode_id,
                'level' => $request->level_id,
                'time' => $timerMinutes,
                'seconds' => $timerSeconds,
                'schedule_id' => $schedule ? $schedule->id : null
            ])
        ]);
    }

    public function resetPracticeScores()
    {
        $user_id = session('student_id');
        if (!$user_id) {
            return response()->json(['success' => false, 'message' => 'User not logged in'], 401);
        }

        \Illuminate\Support\Facades\DB::table('scores')
            ->where('user_id', $user_id)
            ->where('exam_type', 'practice')
            ->update(['is_visible' => 0]);

        return response()->json(['success' => true]);
    }
}
