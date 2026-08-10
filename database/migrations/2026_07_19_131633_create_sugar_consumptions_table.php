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
        Schema::create('sugar_consumptions', function (Blueprint $table) {
           $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('beverage_id')->constrained('beverages')->cascadeOnDelete();
        $table->integer('volume_ml');
        $table->decimal('total_sugar_grams', 6, 2);
        $table->dateTime('consumed_at');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sugar_consumptions');
    }
};
