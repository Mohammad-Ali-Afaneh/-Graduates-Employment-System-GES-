<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\Notification;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    public function showRegisterForm()
    {
        return view('student.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email|max:100',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15',
            'location' => 'required|string|in:عمان,إربد,الزرقاء,البلقاء,الكرك,معان,الطفيلة,العقبة,جرش,عجلون,مادبا,المفرق',
            'gender' => 'required|string|in:ذكر,أنثى',
            'specialization' => 'required|string|in:علوم الحاسوب,هندسة البرمجيات,نظم المعلومات,الأمن السيبراني,تحليل البيانات,تطوير الويب,الذكاء الاصطناعي,إدارة قواعد البيانات,هندسة الشبكات,تطوير تطبيقات الهواتف الذكية,علوم البيانات,الحوسبة السحابية,إنترنت الأشياء (IoT),تطوير الألعاب,الرؤية الحاسوبية',
            'programming_languages' => 'required|array',
            'programming_languages.*' => 'string|in:Python,Java,JavaScript,C++,C#,PHP,Ruby,Go,Swift,Kotlin,TypeScript,R,SQL,Rust,Scala,Perl,MATLAB,Dart,Lua,Elixir,C,F#,Julia,Solidity,Assembly,Groovy,Haskell,Erlang,Clojure,Scheme,Fortran,COBOL,Ada,Prolog,Lisp,Smalltalk,OCaml,D,Crystal,Nim,Zig,V,Apex,Bash,PowerShell,Objective-C,Pascal,Delphi,VHDL,Verilog,T-SQL,PL/SQL,GraphQL,Hack,HCL,Arduino,Scratch,Logo,Malbolge,Brainfuck',
            'score' => 'required|numeric|between:0,100',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $student = new Student();
        $student->name = $validated['name'];
        $student->email = $validated['email'];
        $student->password = Hash::make($validated['password']);
        $student->phone = $validated['phone'];
        $student->location = $validated['location'];
        $student->gender = $validated['gender'];
        $student->specialization = $validated['specialization'];
        $student->score = $validated['score'];

        if (Schema::hasColumn('students', 'programming_languages')) {
            $student->programming_languages = json_encode($validated['programming_languages']);
        }

        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
            $student->cv_path = $cvPath;
        }

        $student->save();

        return redirect()->route('student.login')->with('success', 'تم تسجيل الطالب بنجاح! الرجاء تسجيل الدخول.');
    }

    public function showLoginForm()
    {
        return view('student.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        Log::info('Attempting login for student: ' . $request->email);

        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            Log::warning('Student not found: ' . $request->email);
            return back()->withErrors(['email' => 'البريد الإلكتروني غير موجود.']);
        }

        if (!Hash::check($request->password, $student->password)) {
            Log::warning('Invalid password for student: ' . $request->email);
            return back()->withErrors(['password' => 'كلمة المرور غير صحيحة.']);
        }

        Auth::guard('student')->login($student);
        Log::info('Login successful for student: ' . $request->email);

        return redirect()->route('student.home')->with('success', 'تم تسجيل الدخول بنجاح!');
    }

    public function showJobPostings()
    {
        $studentId = Auth::guard('student')->id();
        $jobApplications = JobApplication::where(function ($query) use ($studentId) {
                $query->whereNull('student_id')
                      ->orWhere(function ($query) use ($studentId) {
                          $query->where('student_id', $studentId)
                                ->where('response', 'pending');
                      });
            })
            ->with('company')
            ->paginate(10);

        return view('student.approved-request', compact('jobApplications'));
    }

    public function showProfile()
    {
        return view('student.student-profile');
    }

    public function updateProfile(Request $request)
    {
        $student = Auth::guard('student')->user();

        Log::info('Update profile request data:', $request->all());

        if (!$request->hasFile('cv') && !$request->has('programming_languages')) {
            Log::warning('No changes to save for student: ' . $student->email);
            return redirect()->route('student.profile')->with('warning', 'لم يتم إجراء أي تغييرات لحفظها.');
        }

        $validated = $request->validate([
            'cv' => 'nullable|file|mimes:pdf|max:2048',
            'programming_languages' => 'required|array',
            'programming_languages.*' => 'string|in:Python,Java,JavaScript,C++,C#,PHP,Ruby,Go,Swift,Kotlin,TypeScript,R,SQL,Rust,Scala,Perl,MATLAB,Dart,Lua,Elixir,C,F#,Julia,Solidity,Assembly,Groovy,Haskell,Erlang,Clojure,Scheme,Fortran,COBOL,Ada,Prolog,Lisp,Smalltalk,OCaml,D,Crystal,Nim,Zig,V,Apex,Bash,PowerShell,Objective-C,Pascal,Delphi,VHDL,Verilog,T-SQL,PL/SQL,GraphQL,Hack,HCL,Arduino,Scratch,Logo,Malbolge,Brainfuck',
        ]);

        if ($request->hasFile('cv')) {
            try {
                $cvPath = $request->file('cv')->store('cvs', 'public');
                $student->cv_path = $cvPath;
                Log::info('CV uploaded successfully: ' . $cvPath);
            } catch (\Exception $e) {
                Log::error('Failed to upload CV: ' . $e->getMessage());
                return redirect()->route('student.profile')->with('error', 'فشل في رفع السيرة الذاتية: ' . $e->getMessage());
            }
        } else {
            Log::info('No CV file uploaded.');
        }

        if (Schema::hasColumn('students', 'programming_languages')) {
            if (isset($validated['programming_languages']) && !empty($validated['programming_languages'])) {
                $student->programming_languages = json_encode($validated['programming_languages']);
                Log::info('Updated programming languages: ' . $student->programming_languages);
            } else {
                Log::warning('No programming languages provided to update.');
                return redirect()->route('student.profile')->with('warning', 'يرجى اختيار لغة برمجة واحدة على الأقل.');
            }
        }

        try {
            $student->save();
            Log::info('Profile updated successfully for student: ' . $student->email);
        } catch (\Exception $e) {
            Log::error('Failed to update profile: ' . $e->getMessage());
            return redirect()->route('student.profile')->with('error', 'فشل في تحديث البروفايل: ' . $e->getMessage());
        }

        return redirect()->route('student.profile')->with('success', 'تم تحديث البروفايل بنجاح!');
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login')->with('success', 'تم تسجيل الخروج بنجاح!');
    }

    public function home()
    {
        $student = Auth::guard('student')->user();
        $notifications = Notification::where('student_id', $student->id)->latest()->get();
        $unreadNotificationsCount = Notification::where('student_id', $student->id)
            ->where('is_read', false)
            ->count();

        Notification::where('student_id', $student->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('student.student-home', compact('notifications', 'unreadNotificationsCount'));
    }

    public function accept(Request $request, $notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        $student = Auth::guard('student')->user();

        if ($notification->student_id !== $student->id) {
            return redirect()->route('student.home')->with('error', 'غير مصرح لك بالرد على هذا الإشعار.');
        }

        $jobApplication = JobApplication::where('student_id', $student->id)
            ->where('company_id', $notification->company_id)
            ->first();

        if ($jobApplication) {
            $jobApplication->response = 'accepted';
            $jobApplication->save();
        }

        return redirect()->route('student.home')->with('success', 'تم قبول الطلب بنجاح!');
    }

    public function reject(Request $request, $notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        $student = Auth::guard('student')->user();

        if ($notification->student_id !== $student->id) {
            return redirect()->route('student.home')->with('error', 'غير مصرح لك بالرد على هذا الإشعار.');
        }

        $jobApplication = JobApplication::where('student_id', $student->id)
            ->where('company_id', $notification->company_id)
            ->first();

        if ($jobApplication) {
            $jobApplication->response = 'rejected';
            $jobApplication->save();
        }

        return redirect()->route('student.home')->with('success', 'تم رفض الطلب بنجاح!');
    }

    public function delete(Request $request, $notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        $student = Auth::guard('student')->user();

        if ($notification->student_id !== $student->id) {
            return redirect()->route('student.home')->with('error', 'غير مصرح لك بحذف هذا الإشعار.');
        }

        $notification->delete();

        return redirect()->route('student.home')->with('success', 'تم حذف الإشعار بنجاح!');
    }

    public function storeJobApplication(Request $request, $jobApplicationId)
    {
        // التحقق من أن المستخدم مسجل الدخول كطالب
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'specialization' => 'required|string',
            'score' => 'required|numeric|between:0,100',
        ]);

        $jobApplication = JobApplication::findOrFail($jobApplicationId);

        if ($jobApplication->student_id !== null) {
            return redirect()->route('student.approved-request')->with('error', 'هذه الوظيفة لديها متقدم بالفعل.');
        }

        $student = Auth::guard('student')->user();
        $jobApplication->student_id = $student->id;
        $jobApplication->specialization = $student->specialization;
        $jobApplication->score = $student->score;
        $jobApplication->response = 'pending';
        $jobApplication->save();

        $company = Company::findOrFail($jobApplication->company_id);

        // تعديل الرسالة لتكون تأكيدًا للطالب
        $message = "تم إرسال طلبك إلى شركة {$company->company_name} بنجاح!\n" .
                   "المسمى الوظيفي: {$jobApplication->title}\n" .
                   "تفاصيل التواصل مع الشركة: {$company->phone}, {$company->email}";

        Notification::create([
            'student_id' => $student->id,
            'company_id' => $company->id,
            'message' => $message,
            'is_read' => false,
            'created_at' => now(),
        ]);

        return redirect()->route('student.approved-request')->with('success', 'تم تقديم الطلب بنجاح!');
    }
}