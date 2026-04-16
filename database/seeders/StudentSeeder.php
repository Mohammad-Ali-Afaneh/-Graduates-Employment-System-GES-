<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudentProgrammingLanguage;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'password' => bcrypt('password'),
                'phone' => '1234567890',
                'location' => 'عمان',
                'gender' => 'ذكر',
                'specialization' => 'هندسة البرمجيات',
                'score' => 85.5,
                'grade' => 'جيد جدًا',
                'cv_path' => 'cvs/ahmed_cv.pdf',
                'programming_languages' => ['Python', 'Java'],
            ],
            [
                'name' => 'خالد عبدالله',
                'email' => 'khalid@example.com',
                'password' => bcrypt('password'),
                'phone' => '0987654321',
                'location' => 'إربد',
                'gender' => 'ذكر',
                'specialization' => 'علوم الحاسوب',
                'score' => 90.0,
                'grade' => 'ممتاز',
                'cv_path' => 'cvs/khalid_cv.pdf',
                'programming_languages' => ['JavaScript', 'C++'],
            ],
            [
                'name' => 'ليان أحمد',
                'email' => 'layan@example.com',
                'password' => bcrypt('password'),
                'phone' => '1122334455',
                'location' => 'الزرقاء',
                'gender' => 'أنثى',
                'specialization' => 'هندسة البرمجيات',
                'score' => 78.0,
                'grade' => 'جيد',
                'cv_path' => 'cvs/layan_cv.pdf',
                'programming_languages' => ['Python', 'JavaScript'],
            ],
            [
                'name' => 'سارة خالد',
                'email' => 'sarah@example.com',
                'password' => bcrypt('password'),
                'phone' => '5566778899',
                'location' => 'العقبة',
                'gender' => 'أنثى',
                'specialization' => 'الأمن السيبراني',
                'score' => 92.5,
                'grade' => 'ممتاز',
                'cv_path' => 'cvs/sarah_cv.pdf',
                'programming_languages' => ['JavaScript', 'C++'],
            ],
            [
                'name' => 'يوسف علي',
                'email' => 'yousef@example.com',
                'password' => bcrypt('password'),
                'phone' => '6677889900',
                'location' => 'الكرك',
                'gender' => 'ذكر',
                'specialization' => 'تحليل البيانات',
                'score' => 88.0,
                'grade' => 'جيد جدًا',
                'cv_path' => 'cvs/yousef_cv.pdf',
                'programming_languages' => ['Python', 'Java', 'JavaScript'],
            ],
        ];

        foreach ($students as $studentData) {
            $programmingLanguages = $studentData['programming_languages'];
            unset($studentData['programming_languages']); // إزالة حقل programming_languages

            // إنشاء الطالب
            $student = Student::create($studentData);

            // إدخال لغات البرمجة إلى جدول student_programming_languages
            foreach ($programmingLanguages as $language) {
                StudentProgrammingLanguage::create([
                    'student_id' => $student->id,
                    'programming_language' => $language,
                ]);
            }
        }
    }
}