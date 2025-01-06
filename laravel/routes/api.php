<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataController;

use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\RequirementController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\ExerciseSkillController;
use App\Http\Controllers\Api\TrainingController;


Route::resources([
    'exercises' =>          ExerciseController::class,
    'requirements' =>       RequirementController::class,
    'skills' =>             SkillController::class,
    'categories' =>         CategoryController::class,
    'trainings' =>          TrainingController::class,
], ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

Route::post('exercises/{exercise_id}/skills/{skill_id}', [ExerciseController::class, 'linkToSkill']);
Route::delete('exercises/{exercise_id}/skills/{skill_id}', [ExerciseController::class, 'unlinkSkill']);


// Route::get('/exercises/search', [ExerciseController::class, 'search']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
