<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tpb_responses', function (Blueprint $table) {
         $table->id();
        $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
        $table->foreignId('question_id')->constrained('tpb_questions')->cascadeOnDelete();
        $table->enum('phase', ['T0', 'T1', 'T2']);
        $table->tinyInteger('score'); // Menyimpan skor skala Likert 1-5
        $table->dateTime('answered_at');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpb_responses');
    }
};
