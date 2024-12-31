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
            return response()->json([
                'success' => false,
                'message' => 'Failed to create exercise.',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Exercise created successfully.',
            'data' => $newExercise
        ], 201);
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
            return response()->json([
                'success' => false,
                'message' => 'Failed to build query',
                'error' => $e->getMessage()
            ], 500);
        }

        try
        {
            $exercise = $exercise->findOrFail($id);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Exercise not found',
                'error' => $e->getMessage()
            ], 404);
        }

        return response()->json($exercise, 200);
    }

    public function edit(string $id)
    {
        // Nah not needed
    }


    public function update(Request $request, string $id)
    {
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
            return response()->json([
                'success' => false,
                'message' => 'Invallid update params',
                'error' => $e->getMessage()
            ], 500);
        }

        $exercise = Exercise::find($id);

        foreach ($validated as $key => $val) {
            $exercise->{$key} = $val;
        }

        $exercise->save();

        return response()->json([
            'success' => true,
            'message' => 'Exercise updated successfully.',
            'data' => $exercise
        ], 200);
    }


    public function destroy(string $id)
    {
        try
        {
            $exercise = Exercise::findOrFail($id);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Exercise not found',
                'error' => $e->getMessage()
            ], 404);
        }

        $exercise->delete();

        return response()->json([
            'success' => true,
            'message' => 'Exercise deleted successfully.',
            'data' => $exercise
        ], 200);
    }
}
