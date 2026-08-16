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
        Schema::create('research_teams', function (Blueprint $table) {
       $table->id();
        $table->string('name');
        $table->string('role', 100);
        $table->string('institution');
        $table->string('photo_url')->nullable();
        $table->text('description')->nullable();
        $table->tinyInteger('sort_order')->default(1);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_teams');
    }
};
