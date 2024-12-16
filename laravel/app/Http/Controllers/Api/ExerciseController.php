<?php

namespace App\Http\Controllers\Api;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        return Exercise::all();
    }

    public function show(Exercise $id)
    {
        $exercise = clone $id;

        $skills = (clone $id)->skills;
        $categories = (clone $id)->skills->pluck('category')->unique('id')->values();

        $exercise->categories = $categories;
        $exercise->skills = $skills;

        return $exercise;
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        // Create a new exercise entry
        $exercise = Exercise::create($validated);

        // Return a success response with the created exercise data
        return response()->json(['message' => 'Exercise added successfully!', 'exercise' => $exercise], 201);
    }
}
