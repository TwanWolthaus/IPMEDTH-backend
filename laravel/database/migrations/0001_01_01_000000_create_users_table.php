<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->foreignId('permission_id')->nullable()->constrained('permissions')->onDelete('set null');
            $table->boolean('disabled');
            $table->char('first_name', 20);
            $table->char('middle_name', 10)->nullable();
            $table->char('last_name', 20);
            $table->string('email', 30)->unique();
            $table->date('date_birth')->nullable();
            $table->char('gender', 1)->nullable();
            $table->char('diploma', 1)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
