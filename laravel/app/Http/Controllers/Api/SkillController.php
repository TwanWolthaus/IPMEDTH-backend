<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Skill;

use Illuminate\Support\Facades\Validator;


class SkillController extends Controller
{

    public function index(Request $request)
    {
        $exercises = Skill::query()

            ->when($request->has('filter.exercises'), function ($query) use ($request) {

                $query->with('exercises');

                if ($request->filter['exercises'] == 'all') return;

                $ids = array_map('intval', explode(',', $request->filter['exercises']));
                $query->whereHas('exercises', function ($query) use ($ids) {
                    $query->whereIn('exercises.id', $ids);
                });
            })

            ->when($request->has('filter.categories'), function ($query) use ($request) {

                $query->with('category');

                if ($request->filter['categories'] == 'all') return;

                $ids = array_map('intval', explode(',', $request->filter['categories']));
                $query->whereHas('category', function ($query) use ($ids) {
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
        $this->authorize('create', Skill::class);

        $request = $request->all();

        if (isset($request['name'])) {
            $request['name'] = ucwords($request['name']);
        }

        $validator = Validator::make($request, [
            'name' =>           'required|string|max:40',
            'category_id' =>    'required|integer|exists:categories,id'
        ]);

        try
        {
            $newSkill = Skill::create($validator->validated());
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create skill.',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Skill created successfully.',
            'data' => $newSkill
        ], 201);
    }


    public function show(Request $request, string $id)
    {
        try
        {
            $skill = Skill::query()

            ->when($request->has('incl'), function ($query) use ($request) {

                $incl = explode(',', $request->get('incl'));
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
            $skill = $skill->findOrFail($id);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Skill not found',
                'error' => $e->getMessage()
            ], 404);
        }

        return response()->json($skill, 200);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $this->authorize('update', Skill::class);

        $request = $request->all();

        $validator = Validator::make($request, [
            'name' =>           'string|max:40',
            'category_id' =>    'integer|exists:categories,id'
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

        if (isset($validated['name'])) {
            $validated['name'] = ucwords($validated['name']);
        }

        $skill = Skill::find($id);

        foreach ($validated as $key => $val) {
            $skill->{$key} = $val;
        }

        try
        {
            $skill->save();
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update skill',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Skill updated successfully.',
            'data' => $skill
        ], 200);
    }


    public function destroy(string $id)
    {
        $this->authorize('delete', Skill::class);

        try
        {
            $skill = Skill::findOrFail($id);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Skill not found, sounds like a skill issue',
                'error' => $e->getMessage()
            ], 404);
        }

        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully.',
            'data' => $skill
        ], 200);
    }
}
