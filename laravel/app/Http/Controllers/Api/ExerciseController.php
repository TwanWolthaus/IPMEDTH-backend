<?php

namespace App\Http\Controllers\Api;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ExerciseController extends Controller
{
//     public function index()
// {
//     $exercises = Exercise::whereHas('skills', function (Builder $query) {
//         $query->where('name', 'like', 'Spieren');
//     })->get();
    
//     // Assuming $exercises is the collection of Exercise instances
//     $exercises->map(function ($exercise) {
//         $skills = (clone $exercise)->skills;
//         $categories = (clone $exercise)->skills->pluck('category')->unique('id')->values();

//         $exercise->categories = $categories;
//         $exercise->skills = $skills;

//         return $exercise;
//     });
    

//     return $exercises;
// }

    // public function index(Request $request){

    //         // Assuming $exercises is the collection of Exercise instances
    // $exercises = Exercise::all()->map(function ($exercise) {
    //     $skills = (clone $exercise)->skills;
    //     $categories = (clone $exercise)->skills->pluck('category')->unique('id')->values();

    //     $exercise->categories = $categories;
    //     $exercise->skills = $skills;

    //     return $exercise;
    // });

    //     $exercises = QueryBuilder::for(Exercise::all()->map(function ($exercise) {
    //         $skills = (clone $exercise)->skills;
    //         $categories = (clone $exercise)->skills->pluck('category')->unique('id')->values();
    
    //         $exercise->categories = $categories;
    //         $exercise->skills = $skills;
    
    //         return $exercise;
    //     }))
    //     ->allowedFilters(['name'])
    //     ->allowedSorts('name')
    //     ->paginate($request->get('perPage', 15));
    //     return response()->json($exercises);
        
    // }




    public function index(Request $request)
    {
        // Extract skills from the 'filter[skills]' query parameter
        $skills = $request->input('filter.skills');
    
        // Fetch exercises using QueryBuilder and apply filters
        $exercises = QueryBuilder::for(Exercise::query())
            ->allowedFilters([
                'name', // Allow filtering by name
                AllowedFilter::scope('skills', 'filterBySkill') // Apply custom scope for skills filter
            ])
            ->allowedSorts(['name']) // Allow sorting by name
            ->with(['skills']) // Eager load related skills
            ->when($skills, function ($query) use ($skills) {
                // Only apply the filter if 'skills' is present in the request
                $query->filterBySkill($skills);
            })
            ->paginate($request->get('perPage', 15)); // Paginate the results, default to 15 items per page
        
        // Return the paginated exercises as JSON response
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
