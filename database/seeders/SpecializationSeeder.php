<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = [
            ['name' => 'هندسة البرمجيات', 'type' => 'specialization'],
            ['name' => 'الأمن السيبراني', 'type' => 'specialization'],
            ['name' => 'تحليل البيانات', 'type' => 'specialization'],
            ['name' => 'تطوير الويب', 'type' => 'specialization'],
            ['name' => 'Python', 'type' => 'programming_language'],
            ['name' => 'Java', 'type' => 'programming_language'],
            ['name' => 'JavaScript', 'type' => 'programming_language'],
            ['name' => 'C++', 'type' => 'programming_language'],
        ];

        foreach ($specializations as $spec) {
            Specialization::firstOrCreate(
                ['name' => $spec['name']], // التحقق بناءً على العمود name
                ['type' => $spec['type']]  // القيم التي سيتم إنشاؤها إذا لم يكن السجل موجودًا
            );
        }
    }
}