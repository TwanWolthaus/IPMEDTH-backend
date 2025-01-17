<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Exercise;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Enums\FilterOperator;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Auth;



class ExerciseController extends Controller
{
    public function index(Request $request)
    {

        $exercises = Exercise::query()

            ->when($request->has('filter.skills'), function ($query) use ($request) {

                $query->with('skills');

                if ($request->filter['skills'] == 'all') return;

                $ids = array_map('intval', explode(',', $request->filter['skills']));
                $query->whereHas('skills', function ($query) use ($ids) {
                    $query->whereIn('skills.id', $ids);
                });
            })

            ->when($request->has('filter.categories'), function ($query) use ($request) {

                $query->with('skills.category');

                if ($request->filter['categories'] == 'all') return;

                $ids = array_map('intval', explode(',', $request->filter['categories']));
                $query->whereHas('skills.category', function ($query) use ($ids) {
                    $query->whereIn('categories.id', $ids);
                });
            })

            ->when($request->has('filter.requirements'), function ($query) use ($request) {

                $query->with('requirements');

                if ($request->filter['requirements'] == 'all') return;

                $ids = array_map('intval', explode(',', $request->filter['requirements']));
                $query->whereHas('requirements', function ($query) use ($ids) {
                    $query->whereIn('requirements.id', $ids);
                });
            })

            ->get();

        return response()->json($exercises, 200);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->authorize('create', Exercise::class);

        $request = $request->all();

        if (isset($request['name'])) {
            $request['name'] = ucwords($request['name']);
        }

        $validator = Validator::make($request, [
            'name' =>               'required|string|max:40',
            'duration' =>           'required|integer|min:1|max:512',
            'minimum_age' =>        'required|integer|min:1|max:255',
            'maximum_age' =>        'integer|min:1|max:255',
            'minimum_players' =>    'required|integer|min:0|max:255',
            'water_exercise' =>     'required|boolean',
            'description' =>        'string',
            'procedure' =>          'string',
            'image_path' =>         'string|max:255',
            'video_path' =>         'string|max:255',
            'image_url' =>          'string|max:255|url',
            'video_url' =>          'string|max:255|url',
        ]);

        try
        {
            $newExercise = Exercise::create($validator->validated());
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Failed to create exercise', 500);
        }

        return $this->getSuccess($newExercise, 'Exercise created successfully', 201);
    }


    public function show(Request $request, string $id)
    {
        try
        {
            $exercise = Exercise::query()

            ->when($request->has('incl'), function ($query) use ($request) {

                $incl = explode(',', $request->get('incl'));

                foreach ($incl as $key => $val) {
                    if ($val === "category") {
                        $incl[$key] = "skills.category";
                    }
                }
                $query->with($incl);
            });
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Failed to biuld query', 500);
        }

        try
        {
            $exercise = $exercise->findOrFail($id);
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Exercise not found', 404);
        }

        return response()->json($exercise, 200);
    }

    public function edit(string $id)
    {
        // Nah not needed
    }


    public function update(Request $request, string $id)
    {
        $this->authorize('update', Exercise::class);

        $request = $request->all();

        $validator = Validator::make($request, [
            'name' =>               'string|max:40',
            'duration' =>           'integer|min:1|max:512',
            'minimum_age' =>        'integer|min:1|max:255',
            'maximum_age' =>        'integer|min:1|max:255|nullable',
            'minimum_players' =>    'integer|min:0|max:255',
            'water_exercise' =>     'boolean',
            'description' =>        'string|nullable',
            'procedure' =>          'string|nullable',
            'image_path' =>         'string|max:255|nullable',
            'video_path' =>         'string|max:255|nullable',
            'image_url' =>          'string|max:255|url|nullable',
            'video_url' =>          'string|max:255|url|nullable',
        ]);

        try
        {
            $validated = $validator->validated();
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Request params invallid', 500);
        }

        $exercise = Exercise::find($id);

        foreach ($validated as $key => $val) {
            $exercise->{$key} = $val;
        }

        $exercise->save();

        return $this->getSuccess($exercise, 'Exercise created successfully', 200);
    }


    public function destroy(string $id)
    {
        $this->authorize('delete', Exercise::class);

        try
        {
            $exercise = Exercise::findOrFail($id);
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Exercise not found', 404);
        }

        $exercise->delete();

        return $this->getSuccess($exercise, 'Exercise deleted successfully', 200);
    }


    public function linkToSkill(string $exerciseId, string $skillIds)
{
    try {
        $exercise = Exercise::findOrFail($exerciseId);  // Find the exercise by ID

        // Convert the comma-separated list of skill IDs to an array of integers
        $skillIds = array_map('intval', explode(',', $skillIds));

        // Attach skills to the exercise
        $exercise->skills()->sync($skillIds);  // Use sync() to associate skills with exercise

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Skills linked to exercise successfully.'
        ], 200);
    } catch (\Exception $e) {
        // Handle errors if any
        return response()->json([
            'error' => 'An error occurred while linking skills to the exercise.'
        ], 500);
    }
}


    public function unlinkSkill(string $exerciseId, string $skillIds)
    {
        $this->authorize('update', Exercise::class);

        $skillIds = array_map('intval', explode(',', $skillIds));
        return $this->setLink(Exercise::class, $exerciseId, 'skills', $skillIds, false);
    }

    public function linkToRequirements(Request $request, string $exerciseId)
{
    try {
        $exercise = Exercise::findOrFail($exerciseId);  // Find the exercise by ID

        // Validate the incoming data
        $validated = $request->validate([
            'requirements' => 'required|array',
            'requirements.*.description' => 'required|string|max:255',
        ]);

        // Detach old requirements and attach the new ones
        $exercise->requirements()->delete();  // Remove existing requirements
        $exercise->requirements()->createMany($validated['requirements']);  // Add new requirements

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Requirements linked to exercise successfully.'
        ], 200);
    } catch (\Exception $e) {
        // Handle errors if any
        return response()->json([
            'error' => 'An error occurred while linking requirements to the exercise.',
            'details' => $e->getMessage()
        ], 500);
    }
}
}
