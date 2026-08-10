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
        Schema::create('school_classes', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel schools (Cascade: Jika sekolah dihapus, kelas ikut terhapus)
        $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
        $table->string('name', 50);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};
