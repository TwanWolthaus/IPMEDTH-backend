<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TrainingExerciseSeeder extends Seeder
{

    public function getIdByName($tableName, $name): int
    {
        return DB::table($tableName)->where('name', $name)->value('id');
    }


    public function run(): void
    {
        DB::table('trainings_exercises')->insert([
            [
                'exercise_id'   => 1,
                'training_id'   => $this->getIdByName('trainings', 'Voor Kinderen'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'exercise_id'   => 4,
                'training_id'   => $this->getIdByName('trainings', 'Voor Kinderen'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'exercise_id'   => 2,
                'training_id'   => $this->getIdByName('trainings', 'Voor Tieners'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'exercise_id'   => 3,
                'training_id'   => $this->getIdByName('trainings', 'Voor Tieners'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'exercise_id'   => 1,
                'training_id'   => $this->getIdByName('trainings', 'Kleine Teams'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'exercise_id'   => 3,
                'training_id'   => $this->getIdByName('trainings', 'Kleine Teams'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'exercise_id'   => 4,
                'training_id'   => $this->getIdByName('trainings', 'Kleine Teams'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        ]);
    }
}
