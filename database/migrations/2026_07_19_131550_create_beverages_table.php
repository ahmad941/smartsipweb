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
        Schema::create('beverages', function (Blueprint $table) {
       $table->id();
        $table->foreignId('category_id')->constrained('beverage_categories')->cascadeOnDelete();
        $table->string('name');
        $table->decimal('sugar_per_100ml', 5, 2);
        $table->string('image_url')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beverages');
    }
};
