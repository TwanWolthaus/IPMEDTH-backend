<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('permission', function (Blueprint $table) {

            $table->id();
            $table->char('name', 20);
            $table->boolean('can_alter_agenda');
            $table->boolean('can_alter_session');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
};
