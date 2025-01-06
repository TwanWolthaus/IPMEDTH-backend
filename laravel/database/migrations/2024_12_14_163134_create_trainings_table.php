<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {

            $table->id();
            $table->foreignId('agenda_id')->nullable()->constrained('agendas')->onDelete('set null');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->char('name', 20)->unique();
            $table->dateTime('start_time', 0)->nullable();
            $table->dateTime('end_time', 0)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
