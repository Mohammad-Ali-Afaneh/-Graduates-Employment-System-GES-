<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    protected $dataExportController;

    public function __construct(DataExportController $dataExportController)
    {
        $this->dataExportController = $dataExportController;
    }

    public function runClustering(Request $request)
    {
        Log::info('بدء عملية التجميع');

        // استدعاء الدالة باستخدام الكائن المحقون
        $export = $this->dataExportController->exportLocations();

        if (isset($export['error'])) {
            Log::error('خطأ في تصدير البيانات: ' . $export['error']);
            return redirect()->route('company.home')->with('error', $export['error']);
        }

        $process = new Process(['python', base_path('ml_models/kmeans_clustering.py')]);
        $process->run();

        if (!$process->isSuccessful()) {
            $errorOutput = $process->getErrorOutput();
            Log::error('فشل تشغيل السكربت: ' . $errorOutput);
            return redirect()->route('company.home')->with('error', 'حدث خطأ أثناء تشغيل التجميع: ' . $errorOutput);
        }

        if (!file_exists(storage_path('app/closest_students.csv'))) {
            Log::error('ملف النتائج غير موجود');
            return redirect()->route('company.home')->with('error', 'لم يتم إنشاء ملف النتائج');
        }

        $closestStudents = array_map('str_getcsv', file(storage_path('app/closest_students.csv')));
        if (empty($closestStudents) || count($closestStudents) <= 1) { // السطر الأول هو العنوان
            Log::error('ملف النتائج فارغ أو لا يحتوي على بيانات كافية');
            return redirect()->route('company.home')->with('error', 'لا توجد نتائج لعرضها');
        }

        Log::info('تم التجميع بنجاح');
        // إعادة التوجيه مع الحفاظ على معايير الفلترة
        return redirect()->route('company.home', [
            'specialization' => $request->input('specialization'),
            'programming_language' => $request->input('programming_language')
        ])->with('closestStudents', $closestStudents);
    }
}