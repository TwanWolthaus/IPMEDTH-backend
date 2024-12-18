<?php

namespace App\Http\Controllers\Api;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
{
    // Assuming $exercises is the collection of Exercise instances
    $exercises = Exercise::all()->map(function ($exercise) {
        $skills = (clone $exercise)->skills;
        $categories = (clone $exercise)->skills->pluck('category')->unique('id')->values();

        $exercise->categories = $categories;
        $exercise->skills = $skills;

        return $exercise;
    });

    return $exercises;
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
    
    public function search(Request $request)
    {
    $query = $request->input('q');

    $results = Exercise::where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->get();

    return response()->json($results);
    }
    
}
