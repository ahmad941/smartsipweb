<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->enum('phase', ['T0', 'T1', 'T2']);
            $table->integer('score'); // 0 to 10
            $table->enum('category', ['Baik', 'Cukup', 'Kurang']); // 8-10 Baik, 6-7 Cukup, 0-5 Kurang
            $table->json('answers'); // question_id => option_selected
            $table->timestamp('answered_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_responses');
    }
};
