<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class DataExportController extends Controller
{
    public function exportLocations()
    {
        Log::info('بدء تصدير البيانات');

        // إحداثيات افتراضية للمواقع
        $locations = [
            'عمان' => ['lat' => 31.9539, 'lon' => 35.9106],
            'إربد' => ['lat' => 32.5568, 'lon' => 35.8469],
            'الزرقاء' => ['lat' => 32.0608, 'lon' => 36.0942],
            'البلقاء' => ['lat' => 32.0367, 'lon' => 35.7288],
            'الكرك' => ['lat' => 31.1812, 'lon' => 35.7046],
            'معان' => ['lat' => 30.1927, 'lon' => 35.7342],
            'الطفيلة' => ['lat' => 30.8375, 'lon' => 35.6042],
            'العقبة' => ['lat' => 29.5321, 'lon' => 35.0063],
            'جرش' => ['lat' => 32.2723, 'lon' => 35.8919],
            'عجلون' => ['lat' => 32.3333, 'lon' => 35.7500],
            'مادبا' => ['lat' => 31.7167, 'lon' => 35.8000],
            'المفرق' => ['lat' => 32.3429, 'lon' => 36.2080],
        ];

        // تصدير بيانات الشركة
        $company = Auth::guard('company')->user();
        if (!$company) {
            Log::error('لا يوجد مستخدم شركة مسجل');
            return ['error' => 'لا يوجد مستخدم شركة مسجل'];
        }

        if (!$company->location || !isset($locations[$company->location])) {
            Log::error('موقع الشركة غير صالح: ' . ($company->location ?? 'غير محدد'));
            return ['error' => 'موقع الشركة غير صالح'];
        }

        // التأكد من أن المجلد موجود
        Storage::makeDirectory('app');

        $companyFilePath = storage_path('app/company_location.csv');
        $companyFile = fopen($companyFilePath, 'w');
        if (!$companyFile) {
            Log::error('فشل فتح ملف company_location.csv للكتابة');
            return ['error' => 'فشل إنشاء ملف بيانات الشركة'];
        }
        fputcsv($companyFile, ['company_id', 'location', 'lat', 'lon']);
        fputcsv($companyFile, [
            $company->id,
            $company->location,
            $locations[$company->location]['lat'],
            $locations[$company->location]['lon']
        ]);
        fclose($companyFile);
        Log::info('تم تصدير بيانات الشركة بنجاح إلى: ' . $companyFilePath);

        // جلب الطلاب المصفّين من الجلسة
        $students = Session::get('filtered_students', []);
        if (empty($students)) {
            Log::error('لا يوجد طلاب مصفّين لتحليل مواقعهم');
            return ['error' => 'لا يوجد طلاب مصفّين لتحليل مواقعهم'];
        }

        $studentFilePath = storage_path('app/students_locations.csv');
        $studentFile = fopen($studentFilePath, 'w');
        if (!$studentFile) {
            Log::error('فشل فتح ملف students_locations.csv للكتابة');
            return ['error' => 'فشل إنشاء ملف بيانات الطلاب'];
        }
        fputcsv($studentFile, ['student_id', 'name', 'location', 'lat', 'lon']);
        $validStudents = 0;
        foreach ($students as $student) {
            if (!isset($student['location']) || !isset($locations[$student['location']])) {
                Log::warning("طالب بدون موقع صالح: " . ($student['name'] ?? 'غير معروف'));
                continue;
            }
            fputcsv($studentFile, [
                $student['id'],
                $student['name'],
                $student['location'],
                $locations[$student['location']]['lat'],
                $locations[$student['location']]['lon']
            ]);
            $validStudents++;
        }
        fclose($studentFile);

        if ($validStudents === 0) {
            Log::error('لا يوجد طلاب بمواقع صالحة لتحليلها');
            return ['error' => 'لا يوجد طلاب بمواقع صالحة لتحليلها'];
        }

        Log::info("تم تصدير بيانات {$validStudents} طالب بنجاح إلى: " . $studentFilePath);
        return ['message' => 'تم تصدير البيانات بنجاح'];
    }
}