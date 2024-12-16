<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('training', function (Blueprint $table) {

            $table->id();
            $table->foreignId('exercise_id')->constrained('exercise')->onDelete('cascade');
            $table->foreignId('agenda_id')->constrained('agenda')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained('location')->onDelete('set null');
            $table->dateTime('start_time', 0);
            $table->dateTime('end_time', 0)->nullable();
            $table->longText('note');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training');
    }
};