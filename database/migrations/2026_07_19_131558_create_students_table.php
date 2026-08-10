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
        Schema::create('students', function (Blueprint $table) {
           $table->id();
        // Relasi 1:1 ke tabel users
        $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
        
        // Relasi ke wilayah pendidikan
        $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
        $table->foreignId('class_id')->constrained('school_classes')->cascadeOnDelete();
        
        // Data Antropometri dan Riset
        $table->string('nickname');
        $table->enum('gender', ['L', 'P']);
        $table->date('date_of_birth');
        $table->decimal('height_cm', 5, 2);
        $table->decimal('weight_kg', 5, 2);
        $table->decimal('bmi_score', 5, 2)->nullable(); // Nullable sementara sebelum dihitung otomatis
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
