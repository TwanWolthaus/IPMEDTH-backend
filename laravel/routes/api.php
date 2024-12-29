<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\DataController;

Route::resource('exercises', ExerciseController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

// Route::get('/exercises/search', [ExerciseController::class, 'search']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
