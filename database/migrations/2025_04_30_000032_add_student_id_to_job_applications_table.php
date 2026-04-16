<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // التحقق من أن العمود غير موجود قبل إضافته
        if (!Schema::hasColumn('job_applications', 'student_id')) {
            Schema::table('job_applications', function (Blueprint $table) {
                $table->unsignedBigInteger('student_id')->nullable()->after('company_id');
                $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
        });
    }
};