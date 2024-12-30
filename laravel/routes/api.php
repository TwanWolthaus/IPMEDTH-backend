<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;

use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\RequirementController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SkillController;

Route::resource('exercises', ExerciseController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::resource('requirements', RequirementController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::resource('skills', SkillController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::resource('categories', CategoryController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

// Route::get('/exercises/search', [ExerciseController::class, 'search']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
