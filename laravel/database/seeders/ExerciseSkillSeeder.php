<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ExerciseSkillSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('exercises_skills')->insert([
            [
                'exercise_id' => 1,
                'skill_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
