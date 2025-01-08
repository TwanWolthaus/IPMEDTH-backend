<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Training;

use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{

    public function index(Request $request)
    {
        $trainings = Training::query()

            ->when($request->has('filter.exercises'), function ($query) use ($request) {

                $query->with('exercises');

                if ($request->filter['exercises'] == 'all') return;

                $ids = array_map('intval', explode(',', $request->filter['exercises']));
                $query->whereHas('exercises', function ($query) use ($ids) {
                    $query->whereIn('exercises.id', $ids);
                });
            })

            ->get();

        return response()->json($trainings, 200);
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
            'name' =>           'required|string|max:40',
            'agenda_id' =>      'nullable|integer|exists:exercises,id',
            'location_id' =>    'nullable|integer|exists:exercises,id',
            'start_time'  =>    'nullable|date|before:end_time',
            'end_time'    =>    'nullable|date|after:start_time',
        ]);

        try
        {
            $newTraining = Training::create($validator->validated());
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Failed to create training', 500);
        }

        return $this->getSuccess($newTraining, 'Training created successfully', 201);
    }


    public function show(Request $request, string $id)
    {
        try
        {
            $training = Training::query()

            ->when($request->has('incl'), function ($query) use ($request) {

                $incl = explode(',', $request->get('incl'));

                $query->with($incl);
            });
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Failed to biuld query', 500);
        }

        try
        {
            $training = $training->findOrFail($id);
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Training not found', 404);
        }

        return response()->json($training, 200);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $request = $request->all();

        $validator = Validator::make($request, [
            'name' =>           'string|max:40',
            'agenda_id' =>      'integer|exists:exercises,id',
            'location_id' =>    'nullable|integer|exists:exercises,id',
            'start_time'  =>    'nullable|date|before:end_time',
            'end_time'    =>    'nullable|date|after:start_time',
        ]);

        try
        {
            $validated = $validator->validated();
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Request params invallid', 500);
        }

        $training = Training::find($id);

        foreach ($validated as $key => $val) {
            $training->{$key} = $val;
        }

        $training->save();

        return $this->getSuccess($training, 'Training saved successfully', 200);
    }


    public function destroy(string $id)
    {
        try
        {
            $training = Training::findOrFail($id);
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Training not found', 404);
        }

        $training->delete();

        return $this->getSuccess($training, 'Training deleted successfully', 200);
    }


    public function linkToExercise(string $trainingId, string $exerciseIds)
    {
        $exerciseIds = array_map('intval', explode(',', $exerciseIds));
        return $this->setLink(Training::class, $trainingId, 'exercises', $exerciseIds, true);
    }


    public function unlinkExercise(string $trainingId, string $exerciseIds)
    {
        $exerciseIds = array_map('intval', explode(',', $exerciseIds));
        return $this->setLink(Training::class, $trainingId, 'exercises', $exerciseIds, false);
    }
}
