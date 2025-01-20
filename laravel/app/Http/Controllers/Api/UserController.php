<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Enums\Role;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()->get();

            // ->when($request->has('filter.exercises'), function ($query) use ($request) {

            //     $query->with('exercise');

            //     if ($request->filter['exercises'] == 'all') return;

            //     $ids = array_map('intval', explode(',', $request->filter['exercises']));
            //     $query->whereHas('exercise', function ($query) use ($ids) {
            //         $query->whereIn('exercises.id', $ids);
            //     });
            // })

            // ->get();

        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request = $request->all();

        if (isset($request['first_name'])) {
            $request['first_name'] = ucwords($request['first_name']);
        }

        $validator = Validator::make($request, [
            'role' =>           'required', Rule::in(array_column(Role::cases(), 'value')),
            'password' =>       'required|string|min:8',
            'disabled' =>       'required|boolean',
            'first_name' =>     'required|string|max:20',
            'middle_name' =>    'nullable|string|max:10',
            'last_name' =>      'required|string|max:20',
            'email' =>          'required|email|max:30|unique:users,email',
            'date_birth' =>     'nullable|date',
            'gender' =>         'nullable|in:M,F,X',
            'diploma' =>        'nullable|in:A,B,C',
        ]);

        try
        {
            $validated = $validator->validated();
            $validated['password'] = Hash::make($validated['password']);
            $newUser = user::create($validated);
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'Failed to create user', 500);
        }



        return $this->getSuccess($newUser, 'User created successfully', 201);
    }


    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', User::class);

        try
        {
            $user = User::findOrFail($id);
        }
        catch (\Exception $e)
        {
            return $this->getError($e, 'User not found', 404);
        }

        $user->delete();

        return $this->getSuccess($training, 'User deleted successfully', 200);
    }
}
