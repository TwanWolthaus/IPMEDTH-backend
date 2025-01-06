<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('trainings_exercises', function (Blueprint $table) {

            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('training_id')->constrained('trainings')->onDelete('cascade');

            $table->timestamps();

            $table->unique(['exercise_id', 'training_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings_exercises');
    }
};
