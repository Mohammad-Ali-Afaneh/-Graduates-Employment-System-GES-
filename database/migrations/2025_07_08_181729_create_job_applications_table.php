<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('job_applications')) {
            Schema::create('job_applications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('company_id');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->unsignedBigInteger('student_id')->nullable();
                $table->string('response')->nullable();
                $table->timestamps();

                $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
                $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('job_applications');
    }
}