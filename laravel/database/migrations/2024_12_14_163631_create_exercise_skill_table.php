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
        Schema::create('exercise_skill', function (Blueprint $table) {

            $table->id();
            $table->foreignId('exercise_id')->constrained('exercise')->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('skill')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_skill');
    }
};