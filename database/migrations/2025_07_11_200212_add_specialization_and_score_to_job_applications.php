<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecializationAndScoreToJobApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('job_applications', 'specialization')) {
                $table->string('specialization')->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'score')) {
                $table->float('score')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
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
}