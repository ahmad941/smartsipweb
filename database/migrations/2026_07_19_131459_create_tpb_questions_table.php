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
        Schema::create('tpb_questions', function (Blueprint $table) {
          $table->id();
        $table->enum('construct_type', ['attitude', 'subjective_norm', 'pbc', 'intention']);
        $table->text('question_text');
        $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpb_questions');
    }
};
