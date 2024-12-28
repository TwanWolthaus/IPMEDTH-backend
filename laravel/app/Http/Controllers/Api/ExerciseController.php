<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Enums\FilterOperator;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;


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
            ->get();

        return response()->json($exercises, 200);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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


    public function show(string $id)
    {
        try
        {
            $exercise = Exercise::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
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
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
