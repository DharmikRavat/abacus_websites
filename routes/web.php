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
use App\Http\Controllers\Admin\CertificationController;
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

Route::get('/franchise-detail', function () {
    return view('client.franchise.index');
})->name('franchise');

Route::get('/exam-test', function () {
    return view('client.exam-test.index');
})->name('exam-test');

Route::get('/exam-score', function () {
    return view('client.exam-test.score');
})->name('exam-score');


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

Route::get('/students/create', [StudentDashboardController::class, 'create'])->name('add-user');
Route::post('/students/store', [StudentController::class, 'add_student'])->name('store-user');

// Choose User
Route::get('/students/choose-user', [StudentDashboardController::class, 'get_added_user'])
    ->name('choose-user');
    Route::post('/student-direct-login', [StudentAuthController::class, 'directLogin'])
    ->name('student.direct.login');

// Exam Routes
Route::get('/students/free-pratice', [StudentDashboardController::class, 'free_practice'])->name('free-practice');
Route::get('/exam-sheet',function(){
    return view('client.dashboard.exam.quiz');
})->name('exam-sheet');

Route::get('/score-sheet',function(){
    return view('client.dashboard.score.index');
})->name('score-sheet');

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
    Route::resource('feedbacks', FeedbackController::class);
    Route::resource('locate-centers', LocateCenterController::class);
    Route::resource('statistics', StatisticsController::class);
    Route::resource('global-presences', GlobalPresenceController::class);
    Route::resource('users', UserController::class);
    Route::get('/report', [ReportController::class, 'index'])
        ->name('report.index');

    Route::get('/report/export', [ReportController::class, 'export'])
        ->name('report.export');
    Route::resource('certification', CertificationController::class);
    Route::get(
        'certification/view/{id}',
        [CertificationController::class, 'showCertificate']
    );
    Route::get('/activity-log', [UserLoginLogController::class, 'index'])
    ->name('activity-log.index');

Route::get('/activity-log/{userLoginLog}', [UserLoginLogController::class, 'show'])
    ->name('activity-log.show');

    Route::resource('student-fees', StudentFeeRecordController::class);
    Route::resource('teacher-fees', TeacherAdmissionController::class);
    Route::resource('student-leads', StudentLeadController::class);

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

        Route::resource('certification', CertificationController::class);
    });
});
