<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // التأكد من وجود الجداول قبل إضافة المفاتيح الأجنبية
        if (Schema::hasTable('students') && Schema::hasTable('company') && Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['company_id']);
        });
    }
};