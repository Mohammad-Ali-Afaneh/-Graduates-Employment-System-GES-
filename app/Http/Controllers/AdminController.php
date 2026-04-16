<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('user_name', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.students');
        }
        return back()->withErrors(['user_name' => 'بيانات تسجيل الدخول غير صحيحة']);
    }

    public function showRegisterForm()
    {
        return view('admin-register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|max:50|unique:admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name' => $validated['name'],
            'user_name' => $validated['user_name'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.login')->with('success', 'تم إنشاء الحساب بنجاح، يرجى تسجيل الدخول.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('home');
    }

    public function index()
    {
        $students = Student::all();
        return view('admin-students', compact('students'));
    }

    public function edit(Student $student)
    {
        return view('edit-student', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,' . $student->id,
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:ذكر,أنثى',
            'specialization' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
            'grade' => 'required|string',
            'programming_languages' => 'required|array',
        ]);

        $student->update($validated);

        return redirect()->route('admin.students')->with('success', 'تم تحديث بيانات الطالب بنجاح.');
    }

    public function delete(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students')->with('success', 'تم حذف الطالب بنجاح.');
    }
}