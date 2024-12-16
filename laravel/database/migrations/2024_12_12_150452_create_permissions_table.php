<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {

            $table->id();
            $table->char('name', 20);
            $table->boolean('can_alter_agendas');
            $table->boolean('can_alter_trainings');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
};
