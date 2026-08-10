<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ffq_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->enum('phase', ['T0', 'T1', 'T2']);
            $table->json('items_data'); // Array of items: beverage_name, frequency, portion_size, sugar_per_100ml, calculated_sugar_grams
            $table->decimal('total_daily_sugar_grams', 8, 2);
            $table->enum('category', ['Baik', 'Sedang', 'Tinggi']); // Baik <25g, Sedang 25-50g, Tinggi >50g
            $table->timestamp('answered_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ffq_responses');
    }
};
