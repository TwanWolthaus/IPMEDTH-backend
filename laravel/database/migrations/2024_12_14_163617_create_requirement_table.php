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
        Schema::create('requirement', function (Blueprint $table) {

            $table->id();
            $table->foreignId('exercise_id')->constrained('exercise')->onDelete('cascade');
            $table->foreignId('tool_id')->constrained('tool')->onDelete('cascade');
            $table->tinyInteger('amount');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirement');
    }
};
