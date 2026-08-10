<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->json('options'); // JSON array of options A, B, C, D
            $table->string('correct_option', 1); // 'A', 'B', 'C', or 'D'
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_questions');
    }
};
