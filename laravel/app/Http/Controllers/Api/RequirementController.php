<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\Requirement;

use Illuminate\Support\Facades\Validator;


class RequirementController extends Controller
{

    public function index(Request $request)
    {
        $requirements = Requirement::query()

            ->when($request->has('filter.exercises'), function ($query) use ($request) {

                $query->with('exercise');

                if ($request->filter['exercises'] == 'all') return;

                $ids = array_map('intval', explode(',', $request->filter['exercises']));
                $query->whereHas('exercise', function ($query) use ($ids) {
                    $query->whereIn('exercises.id', $ids);
                });
            })

            ->get();

        return response()->json($requirements, 200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request = $request->all();

        $validator = Validator::make($request, [
            'exercise_id' =>    'required|integer|exists:exercises,id',
            'description' =>    'required|string|max:255',
            'amount'=>          'required|integer|min:1|max:127',
            'is_optional' =>    'required|boolean'
        ]);

        try
        {
            $newRequirement = Requirement::create($validator->validated());
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create requirement.',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Requirement created successfully.',
            'data' => $newRequirement
        ], 201);
    }


    public function show(string $id)
    {
        try
        {
            $requirement = Requirement::findOrFail($id);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Requirement not found',
                'error' => $e->getMessage()
            ], 404);
        }

        return response()->json($requirement, 200);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $request = $request->all();

        $validator = Validator::make($request, [
            'exercise_id' =>    'integer|exists:exercises,id',
            'description' =>    'string|max:255',
            'amount'=>          'integer|min:1|max:127',
            'is_optional' =>    'boolean'
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

        $requirement = Requirement::find($id);

        foreach ($validated as $key => $val) {
            $requirement->{$key} = $val;
        }

        $requirement->save();

        return response()->json([
            'success' => true,
            'message' => 'Requirement updated successfully.',
            'data' => $requirement
        ], 200);
    }


    public function destroy(string $id)
    {
        try
        {
            $requirement = Requirement::findOrFail($id);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Requirement not found',
                'error' => $e->getMessage()
            ], 404);
        }

        $requirement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Requirement deleted successfully.',
            'data' => $requirement
        ], 200);
    }
}
