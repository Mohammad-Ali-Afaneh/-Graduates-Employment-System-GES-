<?php

     use Illuminate\Database\Migrations\Migration;
     use Illuminate\Database\Schema\Blueprint;
     use Illuminate\Support\Facades\Schema;

     class EnsureGradeColumnInStudentsTable extends Migration
     {
         public function up()
         {
             // التأكد من أن العمود غير موجود قبل إضافته
             if (!Schema::hasColumn('students', 'grade')) {
                 Schema::table('students', function (Blueprint $table) {
                     $table->string('grade')->nullable()->after('score');
                 });
             }
         }

         public function down()
         {
             if (Schema::hasColumn('students', 'grade')) {
                 Schema::table('students', function (Blueprint $table) {
                     $table->dropColumn('grade');
                 });
             }
         }
     }