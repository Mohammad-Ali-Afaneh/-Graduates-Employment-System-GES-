<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('job_applications', 'specialization')) {
                $table->string('specialization')->nullable()->after('student_id');
            }
            if (!Schema::hasColumn('job_applications', 'score')) {
                $table->decimal('score', 5, 2)->nullable()->after('specialization');
            }
        });
    }

    public function down()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            if (Schema::hasColumn('job_applications', 'specialization')) {
                $table->dropColumn('specialization');
            }
            if (Schema::hasColumn('job_applications', 'score')) {
                $table->dropColumn('score');
            }
        });
    }
};