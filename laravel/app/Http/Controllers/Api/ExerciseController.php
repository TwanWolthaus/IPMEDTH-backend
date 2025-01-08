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
        // if(!$request->user() || $request->user()->cannot("viewAny", Exercise::class)) {
        //     return response()->json("Not allowed", 403);
        // }

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
            'exercises.*.name' =>               'required|string|max:40',
            'exercises.*.duration' =>           'required|integer|min:1|max:512',
            'exercises.*.minimum_age' =>        'required|integer|min:1|max:255',
            'exercises.*.maximum_age' =>        'nullable|integer|min:1|max:255',
            'exercises.*.minimum_players' =>    'required|integer|min:0|max:255',
            'exercises.*.water_exercise' =>     'required|boolean',
            'exercises.*.description' =>        'string',
            'exercises.*.procedure' =>          'string',
            'exercises.*.image_path' =>         'string|max:255',
            'exercises.*.video_path' =>         'string|max:255',
            'exercises.*.image_url' =>          'string|max:255|url',
            'exercises.*.video_url' =>          'string|max:255|url',
        ]);

        try
        {
            $validated = $validator->validated();
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Failed to create exercise', 500);
        }

        $createdExercises = [];

        try
        {
            foreach ($validated["exercises"] as $item)
            {
                $createdExercises[] = Exercise::create($item);
            }
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Failed to create exercise', 500);
        }

        return $this->getSuccess($createdExercises, 'Exercises created successfully', 201);
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


    public function linkToSkill(string $exerciseId, string $skillId)
    {
        return $this->setLink(Exercise::class, $exerciseId, 'skills', $skillId, true);
    }


    public function unlinkSkill(string $exerciseId, string $skillId)
    {
        return $this->setLink(Exercise::class, $exerciseId, 'skills', $skillId, false);
    }
}
