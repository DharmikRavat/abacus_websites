<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StandardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TimeTableController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\AcademyProgramController;
use App\Http\Controllers\Admin\FeeTypeController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\FranchisePageController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GlobalPresenceController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\LocateCenterController;
use App\Http\Controllers\Admin\ManageTestController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ProgramWriteupController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuestionTypeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ScoreController;
use App\Http\Controllers\Admin\SliderImageController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\StudentFeeRecordController;
use App\Http\Controllers\Admin\StudentLeadController;
use App\Http\Controllers\Admin\TeacherAdmissionController;
use App\Http\Controllers\Admin\TermsConditionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserLoginLogController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\ExamResultController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestReportController ;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\StudentAuthController;
use App\Http\Controllers\Client\StudentDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/



// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/student-login', function () {
    return view('client.auth.login');
})->name('student-login');

Route::get('/about-us', function () {
    return view('client.about-us.index');
})->name('about-us');

Route::get('/gallery', function () {
    return view('client.gallery.index');
})->name('gallery');

Route::get('/programs', function () {
    return view('client.program.index');
})->name('programs');

Route::get('/contact-us', function () {
    return view('client.contact-us.index');
})->name('contact-us');

Route::post('/contact-submit', [ContactController::class, 'submit'])
    ->name('contact.submit');

Route::get('/franchise-detail', function () {
    return view('client.franchise.index');
})->name('franchise');

Route::get('/exam-test', function () {
    return view('client.exam-test.index');
})->name('exam-test');

Route::get('/exam-score', function () {
    return view('client.exam-test.score');
})->name('exam-score');

Route::get('/locate-center', function () {
    return view('client.locate-center.index');
})->name('locate-center');

Route::get('/tricks-formula', function () {
    return view('client.dashboard.tricks-formula');
})->name('tricks-formula');

Route::get('/feedback', function () {
    return view('client.feedback.index');
})->name('feedback');

Route::get('/privacypolicy', function () {
    return view('client.privacy-policy.index');
})->name('privacypolicy');

Route::get('/termsandconditions', function () {
    return view('client.terms-and-conditions.index');
})->name('termsandconditions');
// ============================
// STUDENT AUTH
// ============================

// Login page
Route::get('/login', [StudentAuthController::class, 'showLogin'])
    ->name('login');

// Login submit
Route::post('/login', [StudentAuthController::class, 'login'])
    ->name('login.submit');

// Logout
Route::get('/logout', [StudentAuthController::class, 'logout'])
    ->name('logout');


// Register page
Route::get('/register', function () {
    return view('client.auth.register');
})->name('register');

// ============================
// STUDENT DASHBOARD
// ============================

Route::resource('dashboard', StudentDashboardController::class);

Route::resource('products', \App\Http\Controllers\Client\ProductController::class)->only(['index']);
Route::resource('feedbacks', \App\Http\Controllers\Client\FeedbackController::class)->only(['create', 'store']);

Route::get('/students/create', [StudentDashboardController::class, 'create'])->name('add-user');
Route::post('/students/store', [StudentDashboardController::class, 'store'])->name('store-user');

// Choose User
Route::get('/students/choose-user', [StudentDashboardController::class, 'get_added_user'])
    ->name('choose-user');
    Route::post('/student-direct-login', [StudentAuthController::class, 'directLogin'])
    ->name('student.direct.login');

// Exam Routes
Route::get('/students/free-pratice', [StudentDashboardController::class, 'free_practice'])->name('free-practice');
Route::get('/exam-sheet',function(\Illuminate\Http\Request $request){
    $minutes = $request->has('time') && $request->time !== '' ? (int)$request->time : 3;
    $seconds = $request->has('seconds') && $request->seconds !== '' ? (int)$request->seconds : 0;
    $mode_id = $request->mode;
    $exam_level_id = $request->level;

    $mode_name = \App\Models\ExamMode::where('id', $mode_id)->value('name');
    $level_number = \App\Models\ExamLevel::where('id', $exam_level_id)->value('level');

    $schedule_id = $request->schedule_id ?? null;
    $schedule = $schedule_id ? \App\Models\TestSchedule::find($schedule_id) : null;

    $query = \Illuminate\Support\Facades\DB::table('questions')
        ->where('difficulty', strtolower($mode_name))
        ->where('exam_level', $level_number)
        ->inRandomOrder();

    if ($schedule && $schedule->no_of_questions) {
        $query->limit($schedule->no_of_questions);
    }

    $dbQuestions = $query->get();
    $dynamicQuestions = [];
    foreach ($dbQuestions as $q) {

        // Split "+22+22+55-33" into ["+22", "+22", "+55", "-33"]
        preg_match_all('/[+-]?\d+/', $q->question, $matches);
        $questionParts = $matches[0] ?? [];

        // Parse options JSON
        $answersArray = [];
        $correctAnswerValue = '';
        $decodedOptions = json_decode($q->options, true);
        if (is_array($decodedOptions)) {
            foreach ($decodedOptions as $key => $val) {
                $answersArray[] = $val;
                if ($key === $q->correct_option) {
                    $correctAnswerValue = $val;
                }
            }
        }

        $dynamicQuestions[] = [
            'id' => $q->id,
            'question' => $questionParts,
            'answers' => $answersArray,
            'correct' => $correctAnswerValue
        ];
    }

    return view('client.dashboard.exam.quiz', [
        'minutes' => $minutes,
        'seconds' => $seconds,
        'mode_id' => $mode_id,
        'exam_level_id' => $exam_level_id,
        'duration_id' => \App\Models\ExamDuration::where('duration_minutes', $minutes)->value('id') ?? 1,
        'dynamicQuestions' => $dynamicQuestions,
        'schedule' => $schedule
    ]);
})->name('exam-sheet');

Route::get('/assessment/{type}', [StudentDashboardController::class, 'assessment_form'])->name('online.assessment');
Route::post('/assessment/get-level', [StudentDashboardController::class, 'get_level'])->name('online.assessment.get-level');
Route::post('/assessment/start', [StudentDashboardController::class, 'start_assessment'])->name('online.assessment.start');

Route::post('/submit-score', [StudentDashboardController::class, 'submit_score'])->name('submit-score');
Route::post('/reset-practice-scores', [StudentDashboardController::class, 'resetPracticeScores'])->name('reset-practice-scores');

Route::get('/score-sheet',function(){
    $user_id = session('student_id');
    if (!$user_id) {
        $user_id = \App\Models\Customer::first()->id ?? 1;
    }

    $practiceScores = \Illuminate\Support\Facades\DB::table('scores')
        ->where('user_id', $user_id)
        ->where('exam_type', 'practice')
        ->leftJoin('exam_modes', 'scores.mode_id', '=', 'exam_modes.id')
        ->leftJoin('exam_levels', 'scores.exam_level_id', '=', 'exam_levels.id')
        ->select('scores.*', 'exam_modes.name as mode', 'exam_levels.level as level')
        ->orderBy('scores.created_at', 'desc')
        ->get();

    $practiceArray = [];
    foreach($practiceScores as $s) {
        $practiceArray[] = [
            'type' => 'Practice Score',
            'mode' => $s->mode ?? 'N/A',
            'level' => 'Level ' . ($s->level ?? 'N/A'),
            'date' => \Carbon\Carbon::parse($s->created_at)->format('d M Y'),
            'raw_date' => \Carbon\Carbon::parse($s->created_at)->format('Y-m-d'),
            'time' => $s->time,
            'total' => $s->total,
            'correct' => $s->correct,
            'wrong' => $s->wrong,
            'skipped' => $s->skipped,
            'is_visible' => $s->is_visible
        ];
    }

    // Test Scores
    $testScores = \Illuminate\Support\Facades\DB::table('scores')
        ->where('user_id', $user_id)
        ->where('exam_type', 'test')
        ->leftJoin('exam_levels', 'scores.exam_level_id', '=', 'exam_levels.id')
        ->select('scores.*', 'exam_levels.level as level')
        ->orderBy('scores.created_at', 'desc')
        ->get();

    @file_put_contents(storage_path('logs/score_debug.txt'), date('Y-m-d H:i:s') . " - score-sheet loaded. user_id: " . $user_id . ", testScores count: " . count($testScores) . "\n", FILE_APPEND);


    $testArray = [];
    foreach($testScores as $s) {
        $testArray[] = [
            'type' => 'Online Test Score',
            'mode' => ucwords(str_replace('_', ' ', $s->schedule_test_type)) ?: 'N/A',
            'level' => 'Level ' . ($s->level ?? 'N/A'),
            'date' => \Carbon\Carbon::parse($s->created_at)->format('d M Y'),
            'raw_date' => \Carbon\Carbon::parse($s->created_at)->format('Y-m-d'),
            'time' => $s->time,
            'total' => $s->total,
            'correct' => $s->correct,
            'wrong' => $s->wrong,
            'skipped' => $s->skipped,
            'is_visible' => $s->is_visible
        ];
    }

    // Exam Scores
    $examScores = \Illuminate\Support\Facades\DB::table('scores')
        ->where('user_id', $user_id)
        ->where('exam_type', 'exam')
        ->leftJoin('exam_levels', 'scores.exam_level_id', '=', 'exam_levels.id')
        ->select('scores.*', 'exam_levels.level as level')
        ->orderBy('scores.created_at', 'desc')
        ->get();

    $examArray = [];
    foreach($examScores as $s) {
        $isPending = $s->result_available_at && \Carbon\Carbon::now()->lt($s->result_available_at);
        $examArray[] = [
            'type' => 'Online Exam Score',
            'mode' => ucwords(str_replace('_', ' ', $s->schedule_test_type)) ?: 'N/A',
            'level' => 'Level ' . ($s->level ?? 'N/A'),
            'date' => \Carbon\Carbon::parse($s->created_at)->format('d M Y'),
            'raw_date' => \Carbon\Carbon::parse($s->created_at)->format('Y-m-d'),
            'time' => $s->time,
            'is_pending' => $isPending,
            'result_available_at' => $s->result_available_at ? \Carbon\Carbon::parse($s->result_available_at)->format('d F Y \a\t h:i A') : null,

            'total' => $isPending ? null : $s->total,
            'correct' => $isPending ? null : $s->correct,
            'wrong' => $isPending ? null : $s->wrong,
            'skipped' => $isPending ? null : $s->skipped,
            'is_visible' => $s->is_visible
        ];
    }

    return view('client.dashboard.score.index', compact('practiceArray', 'testArray', 'examArray'));
})->name('score-sheet');
Route::get('/profile',function(){
    $user_id = session('student_id');
    $user = \App\Models\Customer::find($user_id);
    return view('client.profile.index', compact('user'));
})->name('profile');

Route::get('/profile/edit',function(){
    $user_id = session('student_id');
    $user = \App\Models\Customer::find($user_id);
    $centers = \App\Models\Customer::where('role', 'center')->get();
    return view('client.profile.edit', compact('user', 'centers'));
})->name('profile.edit');

Route::post('/profile/update', function(\Illuminate\Http\Request $request){
    $user_id = session('student_id');
    $user = \App\Models\Customer::find($user_id);
    if (!$user) {
        return back()->with('error', 'User not found!');
    }

    $request->validate([
        'name' => 'required',
        'student_enrollment_id' => 'required',
        'password' => 'required',
        'mobile' => 'required'
    ]);

    if ($request->hasFile('profile')) {
        $file = $request->file('profile');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profiles'), $filename);
        $user->profile = 'uploads/profiles/' . $filename;
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = $request->password;
    $user->mobile = $request->mobile;
    $user->address = $request->address;
    $user->city = $request->city;
    $user->state = $request->state;
    $user->country = $request->country;
    $user->center_id = $request->center_id;
    $user->save();

    return redirect()->route('profile')->with('success', 'Profile updated successfully!');
})->name('profile.update');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    // protected routes
    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });

    /*
    |--------------------------------------------------------------------------
    | Management Module
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | Academy Module
    |--------------------------------------------------------------------------
    */


    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::get(
        'attendance/monthly-report',
        [AttendanceController::class, 'monthlyReport']
    )->name('attendance.monthly-report');

    Route::get(
        'attendance/monthly-report/pdf',
        [AttendanceController::class, 'monthlyReportPdf']
    )->name('attendance.monthly-report.pdf');
    Route::resource('attendance', AttendanceController::class);

    Route::resource('fees', FeeController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('timetable', TimeTableController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('standards', StandardController::class);
    Route::resource('master', MasterController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('academic-years', AcademicYearController::class);
    Route::resource('fee-types', FeeTypeController::class);
    Route::resource('batches', BatchController::class);
    Route::resource('academy-programs', AcademyProgramController::class);
    Route::get('/program-writeup', [ProgramWriteupController::class, 'index'])
    ->name('program-writeup.index');

Route::post('/program-writeup', [ProgramWriteupController::class, 'update'])
    ->name('program-writeup.update');
    Route::resource('faqs', FaqController::class);
    Route::resource('franchise-page', FranchisePageController::class);
    Route::resource('slider-images', SliderImageController::class);
    Route::resource('about-us', AboutUsController::class);
    Route::resource('privacy-policy', PrivacyPolicyController::class)
        ->only(['index', 'update']);
    Route::resource('terms-conditions', TermsConditionController::class)
        ->only(['index', 'update']);
    Route::resource('gallery', GalleryController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('question-types', QuestionTypeController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('manage-tests', ManageTestController::class);
    Route::resource('scores', ScoreController::class);
    Route::post('/scores/{id}/reset', [ScoreController::class, 'reset'])
        ->name('scores.reset');
    Route::resource('feedbacks', FeedbackController::class);
    Route::resource('locate-centers', LocateCenterController::class);
    Route::resource('statistics', StatisticsController::class);
    Route::resource('global-presences', GlobalPresenceController::class);
    Route::resource('users', UserController::class);
    Route::get('/report', [ReportController::class, 'index'])
        ->name('report.index');

    Route::get('/report/export', [ReportController::class, 'export'])
        ->name('report.export');

    Route::get('/activity-log', [UserLoginLogController::class, 'index'])
    ->name('activity-log.index');

Route::get('/activity-log/{userLoginLog}', [UserLoginLogController::class, 'show'])
    ->name('activity-log.show');

    Route::resource('student-fees', StudentFeeRecordController::class);
    Route::resource('teacher-fees', TeacherAdmissionController::class);
    Route::resource('student-leads', StudentLeadController::class);
    Route::resource('products', ProductController::class);

    /*
    |--------------------------------------------------------------------------
    | Setting
    |--------------------------------------------------------------------------
    */
    Route::resource('settings', SettingController::class);

    Route::resource('role', RoleController::class);
});



/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::prefix('teacher')->name('teacher.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

        Route::resource('students', StudentController::class);
        Route::resource('attendance', AttendanceController::class);

        Route::resource('scores', ScoreController::class);

        Route::resource('manage-tests', ManageTestController::class);

        Route::resource('report', ReportController::class);

        Route::get(
            '/test-reports',
            [TestReportController::class, 'index']
        )->name('test-reports.index');

        Route::post(
            '/test-reports',
            [TestReportController::class, 'store']
        )->name('test-reports.store');

        Route::put(
            '/test-reports/{id}',
            [TestReportController::class, 'update']
        )->name('test-reports.update');

        Route::delete(
            '/test-reports/{id}',
            [TestReportController::class, 'destroy']
        )->name('test-reports.destroy');

        Route::get('/exam-results', [ExamResultController::class, 'index'])
        ->name('exam-results.index');

    Route::post('/exam-results', [ExamResultController::class, 'store'])
        ->name('exam-results.store');

    });
});
