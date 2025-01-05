<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('exercises_skills', function (Blueprint $table) {

            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');

            $table->timestamps();

            $table->unique(['exercise_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises_skills');
    }
};
