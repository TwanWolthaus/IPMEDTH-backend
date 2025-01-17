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
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\Auth\AuthController;


// Public recources

Route::resources([
    'exercises' =>          ExerciseController::class,
    'requirements' =>       RequirementController::class,
    'skills' =>             SkillController::class,
    'categories' =>         CategoryController::class,
    'trainings' =>          TrainingController::class,
], ['only' => ['index', 'show']]);

Route::post('login', [AuthController::class, 'login']);
Route::get('deny', [AuthController::class, 'deny'])->name('deny');


// Partially protected recources

Route::middleware('auth:sanctum')->group(function () {

    Route::resources([
        'exercises' =>      ExerciseController::class,
        'requirements' =>   RequirementController::class,
        'skills' =>         SkillController::class,
        'categories' =>     CategoryController::class,
        'trainings' =>      TrainingController::class,
    ], ['only' => ['store', 'update', 'destroy']]);
});


// Fully protected recources

Route::middleware('auth:sanctum')->group(function () {

    // fully protected recourses
    Route::resources([
        'users' =>          UserController::class,
    ], ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

Route::post('exercises/{exerciseId}/linkToSkill/{skillIds}', [ExerciseController::class, 'linkToSkill']);
Route::post('/exercises/{exerciseId}/linkToRequirements', [ExerciseController::class, 'linkToRequirements']);

Route::delete('exercises/{exercise_id}/skills/{skill_id}', [ExerciseController::class, 'unlinkSkill']);

    Route::post('trainings/{trainingId}/exercises/{exerciseId}', [TrainingController::class, 'linkToExercise']);
    Route::delete('trainings/{trainingId}/exercises/{exerciseId}', [TrainingController::class, 'unlinkExercise']);
});




// Route::get('/exercises/search', [ExerciseController::class, 'search']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



