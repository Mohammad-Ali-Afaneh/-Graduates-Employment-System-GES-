<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;

class UpdateStudentGrades extends Command
{
    protected $signature = 'students:update-grades';
    protected $description = 'Update grades for students based on their scores';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $students = Student::all();

        if ($students->isEmpty()) {
            $this->info('No students found to update grades.');
            return;
        }

        foreach ($students as $student) {
            if ($student->score >= 90) {
                $student->grade = 'ممتاز';
            } elseif ($student->score >= 80) {
                $student->grade = 'جيد جدًا';
            } elseif ($student->score >= 70) {
                $student->grade = 'جيد';
            } elseif ($student->score >= 50) {
                $student->grade = 'مقبول';
            } else {
                $student->grade = 'راسب';
            }
            $student->save();
        }

        $this->info('Grades updated successfully for ' . $students->count() . ' students!');
    }
}