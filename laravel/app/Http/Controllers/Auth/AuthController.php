<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // $request = $request;

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ], true)) {
            $user = Auth::user();

            $token = $user->createToken('ZVL Trainingen')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ]);

        } else {
            dd('Login failed');
        }
    }


    public function deny(Request $request)
    {
        return response()->json("Unauthorized", 401);
    }

}
