<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;

use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\RequirementController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SkillController;

Route::resources([
    'exercises' =>      ExerciseController::class,
    'requirements' =>   RequirementController::class,
    'skills' =>         SkillController::class,
    'categories' =>     CategoryController::class,
], ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

// Route::get('/exercises/search', [ExerciseController::class, 'search']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
