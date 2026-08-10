<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->boolean('informed_consent')->default(true)->after('user_id');
            $table->string('pocket_money')->nullable()->after('bmi_score');
            $table->string('father_education')->nullable()->after('pocket_money');
            $table->string('mother_education')->nullable()->after('father_education');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['informed_consent', 'pocket_money', 'father_education', 'mother_education']);
        });
    }
};
