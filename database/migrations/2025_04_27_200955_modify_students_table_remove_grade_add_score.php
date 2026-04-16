<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // إزالة الحقل grade إذا كان موجودًا
            if (Schema::hasColumn('students', 'grade')) {
                $table->dropColumn('grade');
            }

            // إضافة الحقل score إذا لم يكن موجودًا، بعد عمود gender أو specialization حسب السياق
            if (!Schema::hasColumn('students', 'score')) {
                $table->decimal('score', 5, 2)->nullable()->after('specialization');
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // إزالة score إذا كان موجودًا
            if (Schema::hasColumn('students', 'score')) {
                $table->dropColumn('score');
            }
            // إعادة إضافة grade إذا لم يكن موجودًا
            if (!Schema::hasColumn('students', 'grade')) {
                $table->string('grade', 20)->nullable()->after('gender');
            }
        });
    }
};