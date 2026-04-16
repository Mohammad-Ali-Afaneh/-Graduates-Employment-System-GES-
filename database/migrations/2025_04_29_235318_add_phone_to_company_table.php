<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('company', 'phone')) {
            Schema::table('company', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('location');
            });
        }
    }

    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};