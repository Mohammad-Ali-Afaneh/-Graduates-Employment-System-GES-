<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            // تعديل العمود gender للسماح بقيم إضافية
            $table->enum('gender', ['Male', 'Female', 'غير محدد'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            // إعادة العمود إلى الحالة السابقة
            $table->enum('gender', ['Male', 'Female'])->change();
        });
    }
};