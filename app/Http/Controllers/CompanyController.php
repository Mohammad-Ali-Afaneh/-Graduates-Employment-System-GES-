<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\Student;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CompanyController extends Controller
{
    public function showRegisterForm()
    {
        return view('company.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255|unique:company,company_name',
            'location' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:company,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $company = new Company();
        $company->company_name = $request->company_name;
        $company->location = $request->location;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->password = Hash::make($request->password);
        $company->save();

        return redirect()->route('company.login')->with('success', 'تم تسجيل الشركة بنجاح! الرجاء تسجيل الدخول.');
    }

    public function showLoginForm()
    {
        return view('company.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'password' => 'required|string',
        ]);

        Log::info('Attempting login for company: ' . $request->company_name);

        $company = Company::where('company_name', $request->company_name)->first();

        if (!$company) {
            Log::warning('Company not found: ' . $request->company_name);
            return back()->withErrors(['company_name' => 'اسم الشركة غير موجود.']);
        }

        if (!Hash::check($request->password, $company->password)) {
            Log::warning('Invalid password for company: ' . $request->company_name);
            return back()->withErrors(['password' => 'كلمة المرور غير صحيحة.']);
        }

        Auth::guard('company')->login($company);
        Log::info('Login successful for company: ' . $request->company_name);

        return redirect()->route('company.home')->with('success', 'تم تسجيل الدخول بنجاح!');
    }

    public function logout(Request $request)
    {
        Auth::guard('company')->logout();
        return redirect()->route('company.login')->with('success', 'تم تسجيل الخروج بنجاح!');
    }

    public function showCreateRequest()
    {
        return view('company.create-request');
    }

    public function storeJobPosting(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $company = Auth::guard('company')->user();

        $jobPosting = new JobApplication();
        $jobPosting->company_id = $company->id;
        $jobPosting->title = $validated['job_title'];
        $jobPosting->description = $validated['description'];
        $jobPosting->save();

        return redirect()->route('company.home')->with('success', 'تم إنشاء إعلان الوظيفة بنجاح!');
    }

    public function showCompanyHome(Request $request)
    {
        if ($request->session()->has('closestStudents')) {
            $closestStudents = $request->session()->get('closestStudents');
            $closestStudents = array_slice($closestStudents, 1);
            $studentIds = array_column($closestStudents, 0);
            $query = Student::whereIn('id', $studentIds);
            $orderByCase = 'CASE id ';
            foreach ($studentIds as $index => $id) {
                $orderByCase .= "WHEN {$id} THEN {$index} ";
            }
            $orderByCase .= 'END';
            $students = $query->orderByRaw($orderByCase)->paginate(10);
            Log::info('Students fetched based on closestStudents:', $students->toArray());
            $request->session()->forget('closestStudents');
        } else {
            $query = Student::query()->distinct('id');
            if ($request->has('specialization') && !empty($request->specialization)) {
                $query->where('specialization', $request->specialization);
            }
            if ($request->has('programming_language') && !empty($request->programming_language)) {
                $query->whereJsonContains('programming_languages', $request->programming_language);
            }
            $filteredStudents = $query->get();
            $request->session()->put('filtered_students', $filteredStudents->toArray());
            $students = $query->paginate(10);
            Log::info('Students fetched for company home:', $students->toArray());
        }

        return view('company.company-home', compact('students'));
    }

    public function showEmployees()
    {
        $companyId = Auth::guard('company')->id();
        $jobApplications = JobApplication::where('company_id', $companyId)
            ->whereNotNull('student_id')
            ->with(['student', 'company'])
            ->get();

        $rejectedApplications = JobApplication::where('company_id', $companyId)
            ->where('response', 'rejected')
            ->with(['student', 'company'])
            ->get();

        return view('company.employees', compact('jobApplications', 'rejectedApplications'));
    }

    public function showReceiveRequests()
    {
        $companyId = Auth::guard('company')->id();
        $query = JobApplication::where('company_id', $companyId)
            ->where(function ($q) {
                $q->whereNull('specialization')
                  ->orWhere('specialization', '!=', 'تم اختياره من قبل الشركة');
            });

        $jobPostings = $query->with(['company', 'student'])->paginate(10);

        if ($jobPostings->isEmpty()) {
            Log::info('No job postings found for company ID: ' . $companyId);
        }

        return view('company.receive-request', compact('jobPostings'));
    }

    public function showStudentDetails($studentId)
    {
        $student = Student::with('programmingLanguages')->findOrFail($studentId);
        return view('company.student-details', compact('student'));
    }

    public function notifyStudent(Request $request, $studentId)
    {
        $request->validate([
            'interview_details' => 'required|string',
        ]);

        $company = Auth::guard('company')->user();
        $interviewDetails = $request->interview_details;

        $jobApplication = new JobApplication();
        $jobApplication->specialization = 'تم اختياره من قبل الشركة';
        $jobApplication->company_id = $company->id;
        $jobApplication->student_id = $studentId;
        $jobApplication->response = 'pending';
        $jobApplication->save();

        $message = "تم إرسال طلب لك من شركة {$company->company_name} للتوظيف!\n" .
                   "يمكنك التواصل مع الشركة عبر:\n" .
                   "رقم الهاتف: {$company->phone}\n" .
                   "البريد الإلكتروني: {$company->email}\n" .
                   "تفاصيل المقابلة: {$interviewDetails}";

        Notification::create([
            'student_id' => $studentId,
            'company_id' => $company->id,
            'message' => $message,
            'interview_details' => $interviewDetails,
            'is_read' => false,
            'created_at' => now(),
        ]);

        // التحقق من وجود العمود 'is_notified' قبل التحديث
        if (Schema::hasColumn('job_applications', 'is_notified')) {
            $jobApplication->update(['is_notified' => true]);
        } else {
            Log::warning('العمود "is_notified" غير موجود في جدول job_applications. لم يتم تحديث حالة الإشعار.');
        }

        return redirect()->route('company.student-details', $studentId)->with('success', 'تم إرسال الإشعار بنجاح!');
    }

    public function deleteJobApplication(Request $request, $jobApplicationId)
    {
        if (!Auth::guard('company')->check()) {
            Log::warning('Unauthorized attempt to delete job application by non-company user');
            return redirect()->route('company.employees')->with('error', 'غير مصرح لك بحذف هذا الطلب.');
        }

        $jobApplication = JobApplication::findOrFail($jobApplicationId);

        if ($jobApplication->company_id !== Auth::guard('company')->id()) {
            return redirect()->route('company.employees')->with('error', 'غير مصرح لك بحذف هذا الطلب.');
        }

        $jobApplication->delete();

        $redirectTo = $request->input('redirect_to', 'company.employees');
        return redirect()->route($redirectTo)->with('success', 'تم حذف الطلب بنجاح!');
    }

    public function deleteJobPosting(Request $request, $jobApplicationId)
    {
        if (!Auth::guard('company')->check()) {
            Log::warning('Unauthorized attempt to delete job posting by non-company user');
            return redirect()->route('company.receive-request')->with('error', 'غير مصرح لك بحذف هذا الإعلان.');
        }

        $jobApplication = JobApplication::findOrFail($jobApplicationId);

        if ($jobApplication->company_id !== Auth::guard('company')->id()) {
            return redirect()->route('company.receive-request')->with('error', 'غير مصرح لك بحذف هذا الإعلان.');
        }

        $jobApplication->delete();

        $redirectTo = $request->input('redirect_to', 'company.receive-request');
        return redirect()->route($redirectTo)->with('success', 'تم حذف الإعلان بنجاح!');
    }

    public function showJobApplicants($jobApplicationId)
    {
        $jobApplication = JobApplication::with('student')->findOrFail($jobApplicationId);

        if ($jobApplication->company_id !== Auth::guard('company')->id()) {
            return redirect()->route('company.receive-request')->with('error', 'غير مصرح لك بالوصول إلى هذه الصفحة.');
        }

        $query = JobApplication::where('company_id', $jobApplication->company_id)
            ->where('id', $jobApplicationId)
            ->whereNotNull('student_id');

        // التحقق من وجود العمود 'is_notified'
        if (Schema::hasColumn('job_applications', 'is_notified')) {
            $query->where('is_notified', false);
        } else {
            Log::warning('العمود "is_notified" غير موجود في جدول job_applications. تأكد من تشغيل الترحيل.');
        }

        $applicants = $query->with('student')->get();

        return view('company.job-applicants', compact('applicants', 'jobApplication'));
    }

    public function runClustering(Request $request)
    {
        $exportController = new DataExportController();
        $exportResult = $exportController->exportLocations();

        if (isset($exportResult['error'])) {
            Log::error('Failed to export locations: ' . $exportResult['error']);
            return redirect()->route('company.home')->with('error', $exportResult['error']);
        }

        $pythonScript = base_path('ml_models/kmeans_clustering.py');
        $command = "python " . escapeshellarg($pythonScript) . " 2>&1";
        $output = shell_exec($command);

        if (strpos($output, 'Successfully saved') === false) {
            Log::error('Failed to run clustering script: ' . $output);
            return redirect()->route('company.home')->with('error', 'فشل في تشغيل الفلترة المتقدمة: ' . $output);
        }

        $closestStudentsFile = storage_path('app/closest_students.csv');
        if (!file_exists($closestStudentsFile)) {
            Log::error('Closest students file not found at: ' . $closestStudentsFile);
            return redirect()->route('company.home')->with('error', 'لم يتم العثور على ملف الطلاب الأقرب');
        }

        $closestStudents = array_map('str_getcsv', file($closestStudentsFile));
        if (empty($closestStudents) || count($closestStudents) <= 1) {
            Log::error('No valid data in closest_students.csv');
            return redirect()->route('company.home')->with('error', 'لا توجد بيانات طلاب مفلترة لعرضها');
        }

        $request->session()->put('closestStudents', $closestStudents);

        return redirect()->route('company.home')->with('success', 'تم تشغيل الفلترة المتقدمة بنجاح!');
    }

    public function acceptApplicant($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);
        $company = Auth::guard('company')->user();

        if ($application->company_id !== $company->id) {
            return redirect()->back()->with('error', 'غير مصرح لك بالوصول إلى هذا الطلب.');
        }

        $application->response = 'accepted';
        $application->save();

        Notification::create([
            'student_id' => $application->student_id,
            'company_id' => $application->company_id,
            'message' => "تم قبول طلبك للوظيفة: {$application->title} من شركة {$company->company_name}. يمكنك التواصل مع الشركة عبر: {$company->phone} أو {$company->email}",
            'is_read' => false,
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم قبول المتقدم بنجاح!');
    }

    public function rejectApplicant($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);
        $company = Auth::guard('company')->user();

        if ($application->company_id !== $company->id) {
            return redirect()->back()->with('error', 'غير مصرح لك بالوصول إلى هذا الطلب.');
        }

        $application->response = 'rejected';
        $application->save();

        Notification::create([
            'student_id' => $application->student_id,
            'company_id' => $application->company_id,
            'message' => "تم رفض طلبك للوظيفة: {$application->title} من شركة {$company->company_name}.",
            'is_read' => false,
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم رفض المتقدم بنجاح!');
    }
}