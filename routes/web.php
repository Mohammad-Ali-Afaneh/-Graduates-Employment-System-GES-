<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\DataExportController;

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// مسار تسجيل الدخول العام
Route::get('/login', function () {
    if (Auth::guard('student')->check()) {
        return redirect()->route('student.home');
    }
    if (Auth::guard('company')->check()) {
        return redirect()->route('company.home');
    }
    return redirect()->route('student.login'); // الافتراضي للطلاب
})->name('login');

// مسارات تسجيل وتسجيل الدخول للطالب
Route::get('/student/register', [StudentController::class, 'showRegisterForm'])->name('student.register');
Route::post('/student/register', [StudentController::class, 'register']);
Route::get('/student/login', [StudentController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentController::class, 'login']);
Route::get('/student/home', [StudentController::class, 'home'])->middleware('auth:student')->name('student.home');
Route::get('/student/profile', [StudentController::class, 'showProfile'])->middleware('auth:student')->name('student.profile');
Route::patch('/student/profile', [StudentController::class, 'updateProfile'])->middleware('auth:student')->name('student.updateProfile');
Route::post('/student/logout', [StudentController::class, 'logout'])->middleware('auth:student')->name('student.logout');

// مسار جديد لعرض السيرة الذاتية للطالب
Route::get('/student/cv', [StudentController::class, 'showCv'])->middleware('auth:student')->name('student.cv.show');

// مسارات لمعالجة ردود الطالب
Route::post('/student/accept/{notification}', [StudentController::class, 'accept'])->name('student.accept')->middleware('auth:student');
Route::post('/student/reject/{notification}', [StudentController::class, 'reject'])->name('student.reject')->middleware('auth:student');
Route::delete('/student/delete/{notification}', [StudentController::class, 'delete'])->name('student.delete')->middleware('auth:student');

// مسارات تسجيل وتسجيل الدخول للشركة
Route::get('/company/register', [CompanyController::class, 'showRegisterForm'])->name('company.register');
Route::post('/company/register', [CompanyController::class, 'register']);
Route::get('/company/login', [CompanyController::class, 'showLoginForm'])->name('company.login');
Route::post('/company/login', [CompanyController::class, 'login']);
Route::post('/company/logout', [CompanyController::class, 'logout'])->name('company.logout');
Route::get('/company/home', [CompanyController::class, 'showCompanyHome'])->name('company.home')->middleware('auth:company');

// مسار عرض المتقدمين
Route::get('/company/receive-request', [CompanyController::class, 'showReceiveRequests'])->name('company.receive-request')->middleware('auth:company');

// مسار جديد للمتقدمين باسم company.employees
Route::get('/company/employees', [CompanyController::class, 'showEmployees'])->name('company.employees')->middleware('auth:company');

// مسار إرسال الإشعار
Route::post('/company/notify-student/{student}', [CompanyController::class, 'notifyStudent'])->name('company.notifyStudent')->middleware('auth:company');

// مسار جديد لحذف طلب التوظيف (محصور بالشركات فقط) - لـ employees.blade.php
Route::delete('/company/job-applications/delete/{jobApplicationId}', [CompanyController::class, 'deleteJobApplication'])->name('company.deleteJobApplication')->middleware('auth:company');

// مسار جديد لحذف إعلان الوظيفة (محصور بالشركات فقط) - لـ receive-request.blade.php
Route::delete('/company/job-postings/delete/{jobApplicationId}', [CompanyController::class, 'deleteJobPosting'])->name('company.deleteJobPosting')->middleware('auth:company');

// مسار جديد لعرض المتقدمين على وظيفة معينة
Route::get('/company/job-applicants/{jobApplicationId}', [CompanyController::class, 'showJobApplicants'])->name('company.job-applicants')->middleware('auth:company');

// مسار جديد لقبول المتقدم
Route::post('/company/accept-applicant/{applicationId}', [CompanyController::class, 'acceptApplicant'])->name('company.accept-applicant')->middleware('auth:company');

// مسار جديد لرفض المتقدم
Route::post('/company/reject-applicant/{applicationId}', [CompanyController::class, 'rejectApplicant'])->name('company.reject-applicant')->middleware('auth:company');

// مسار جديد لتسجيل طلب الوظيفة (من الطالب)
Route::post('/student/job-applications/{jobApplicationId}', [StudentController::class, 'storeJobApplication'])->name('student.store-job-application')->middleware('auth:student');

Route::middleware(['auth:company'])->group(function () {
    Route::get('/company/student-details/{studentId}', [CompanyController::class, 'showStudentDetails'])->name('company.student-details');
    Route::get('/cv/{id}', [CvController::class, 'show'])->name('cv.show');
});

// مسارات تسجيل وتسجيل الدخول للأدمن
Route::get('/admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'register']);
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

// مسارات إدارة الطلاب (للأدمن)
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/students', [AdminController::class, 'index'])->name('admin.students');
    Route::get('/students/{student}/edit', [AdminController::class, 'edit'])->name('admin.student.edit');
    Route::put('/students/{student}', [AdminController::class, 'update'])->name('admin.student.update');
    Route::delete('/students/{student}', [AdminController::class, 'delete'])->name('admin.student.delete');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

// المسارات الجديدة لتحليل المواقع
Route::get('/export-locations', [DataExportController::class, 'exportLocations'])->name('export.locations')->middleware('auth:company');
Route::get('/run-clustering', [CompanyController::class, 'runClustering'])->name('clusters.run')->middleware('auth:company');

// مسارات إنشاء وعرض الوظائف
Route::get('/company/create-request', [CompanyController::class, 'showCreateRequest'])->name('company.create-request')->middleware('auth:company');
Route::post('/company/create-request', [CompanyController::class, 'storeJobPosting'])->name('company.store-job-posting')->middleware('auth:company');
Route::get('/student/job-postings', [StudentController::class, 'showJobPostings'])->name('student.approved-request')->middleware('auth:student');