<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usability_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->json('scores'); // Item 1-10 scores (1-5 Likert)
            $table->integer('total_score'); // 10 to 50
            $table->enum('category', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang']); // 41-50 Sangat Baik, 31-40 Baik, 21-30 Cukup, <=20 Kurang
            $table->timestamp('answered_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usability_responses');
    }
};
