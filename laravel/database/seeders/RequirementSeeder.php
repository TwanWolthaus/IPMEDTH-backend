<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RequirementSeeder extends Seeder
{

    public function getIdByName($tableName, $name): int
    {
        return DB::table($tableName)->where('name', $name)->value('id');
    }


    public function run(): void
    {
        $requirementOnExercise = [
            'Hete Aardappel' => [['1 Bal Per Groep', false], ['Fluitje', false]],
            'Luister Naar De Hand' => [['Fluitje', false], ['Bal Per Paar', true]],
        ];

        foreach ($requirementOnExercise as $exerciseName => $reqs) {

            foreach ($reqs as $req) {

                DB::table('requirements')->insert([
                    [
                        'exercise_id' =>    $this->getIdByName('exercises', $exerciseName),
                        'description' =>    $req[0],
                        'amount' =>         1,
                        'is_optional' =>    $req[1],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
        }
    }
}
