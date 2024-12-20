<?php

namespace App\Http\Controllers\Api;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Enums\FilterOperator;

class ExerciseController extends Controller
{

    public function index(Request $request)
    {
        // Use QueryBuilder for filtering and sorting
        $exercises = QueryBuilder::for(Exercise::query())
            // Allow filtering by name and skill
            ->allowedFilters([
                'name', // Allow filtering by name
                AllowedFilter::scope('skills', 'filterBySkill'), // Allow filtering by skills
                AllowedFilter::scope('categories', 'filterByCategory'),
                AllowedFilter::scope('duration_between'),
                AllowedFilter::scope('water_exercise'),
            
                ])
            // Allow sorting by name
            ->allowedSorts(['name'])
            // Eager load relationships, assuming each exercise has skills
            ->with(['skills'])
            // Paginate results
            ->paginate($request->get('perPage', 15));
    
        // Attach categories for each exercise
        $exercises->getCollection()->transform(function ($exercise) {
            // Get the unique categories associated with each exercise
            $categories = $exercise->skills->pluck('category')->unique('id')->values();
    
            // Add categories to the exercise object
            $exercise->categories = $categories;
    
            return $exercise;
        });
    
        // Return the paginated response with categories
        return response()->json($exercises);
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
            'name' => 'required|string|max:255',
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
