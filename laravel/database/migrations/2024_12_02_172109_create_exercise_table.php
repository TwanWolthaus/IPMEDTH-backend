<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('exercise', function (Blueprint $table) {

            $table->id();
            $table->char('name', 20);
            $table->smallInteger('duration')->unsigned();
            $table->tinyInteger('minimum_age')->unsigned();
            $table->tinyInteger('maximum_age')->unsigned()->nullable();
            $table->tinyInteger('minimum_players')->unsigned();
            $table->boolean('water_exercise');
            $table->string('description', 255)->nullable();
            $table->string('procedure', 255)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->string('video_path', 255)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->string('video_url', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('exercise');
    }
};
