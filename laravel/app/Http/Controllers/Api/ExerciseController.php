<?php

namespace App\Http\Controllers\Api;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        return Exercise::all();
    }
}