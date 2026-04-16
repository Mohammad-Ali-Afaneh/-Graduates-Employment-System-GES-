<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\StudentProgrammingLanguage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // إدخال بيانات لجدول admin
        DB::table('admin')->insert([
            'name' => 'Admin User',
            'user_name' => 'admin1',
            'password' => Hash::make('adminpass123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // إدخال بيانات لجدول company
        DB::table('company')->insert([
            [
                'user_name' => 'techco',
                'company_name' => 'شركة تقنية',
                'email' => 'techco@example.com',
                'company_address' => 'عمان',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'softco',
                'company_name' => 'شركة برمجيات',
                'email' => 'softco@example.com',
                'company_address' => 'الزرقاء',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // إدخال بيانات لجدول students
        $studentsData = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'phone' => '+962123456789',
                'location' => 'عمان',
                'gender' => 'ذكر',
                'specialization' => 'هندسة البرمجيات',
                'score' => 92.5,
                'grade' => 'امتياز',
                'cv_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'programming_languages' => ['Python', 'Java'],
            ],
            [
                'name' => 'سارة علي',
                'email' => 'sara@example.com',
                'phone' => '+962987654321',
                'location' => 'إربد',
                'gender' => 'أنثى',
                'specialization' => 'علوم بيانات',
                'score' => 78.0,
                'grade' => 'جيد جداً',
                'cv_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'programming_languages' => ['JavaScript', 'R'],
            ],
        ];

        foreach ($studentsData as $studentData) {
            $programmingLanguages = $studentData['programming_languages'];
            unset($studentData['programming_languages']);

            $student = Student::create($studentData);

            // إدخال لغات البرمجة في جدول student_programming_languages
            foreach ($programmingLanguages as $language) {
                StudentProgrammingLanguage::create([
                    'student_id' => $student->id,
                    'programming_language' => $language,
                ]);
            }
        }
    }
}