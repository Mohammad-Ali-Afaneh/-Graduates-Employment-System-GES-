<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CvController extends Controller
{
    public function show($id)
    {
        $student = Student::findOrFail($id);

        // لا حاجة للتحقق من JobApplication، أي شركة مسجلة يمكنها الوصول
        // المصادقة عبر auth:company كافية (تم التحقق منها في web.php)
        $company = Auth::guard('company')->user();
        Log::info("Company {$company->id} accessed CV of student {$student->id}");

        $filePath = $student->cv_path;

        // تصحيح المسار للتوافق مع Windows
        $filePath = str_replace('\\', '/', $filePath);

        // تسجيل المسار للتحقق منه
        Log::info("Attempting to access CV file for student {$student->id} at path: {$filePath}");

        if (Storage::disk('public')->exists($filePath)) {
            try {
                $fileContents = Storage::disk('public')->get($filePath);
                $fileName = basename($filePath);

                Log::info("Successfully accessed CV file for student {$student->id}");

                return response($fileContents, 200)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="' . $fileName . '"');
            } catch (\Exception $e) {
                Log::error("Failed to access CV file for student {$student->id}: " . $e->getMessage());
                abort(500, 'حدث خطأ أثناء محاولة عرض السيرة الذاتية');
            }
        }

        Log::warning("CV file not found for student {$student->id} at path: {$filePath}");
        abort(404, 'الملف غير موجود');
    }
}