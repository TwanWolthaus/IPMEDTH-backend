<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ExerciseSkillSeeder extends Seeder
{
    public function getIdByName($tableName, $name): int
    {
        return DB::table($tableName)->where('name', $name)->value('id');
    }


    public function run(): void
    {
        $exerciseOnSkill = [
            'Wedstrijdje Onderduwen'        => ['Spieren', 'Verdediging'],
            'Lucht Happen En Ondertrekken'  => ['Ademhaling', 'Aanval'],
            'Hete Aardappel'                => ['Cardio', 'Gooien-Vangen', 'Wedstrijdstress'],
            'Luister Naar De Hand'          => ['Regels', 'Handgebaren-Scheidsrechter', 'Heads-Up'],
        ];


        foreach ($exerciseOnSkill as $exerciseName => $skillNames) {

            foreach ($skillNames as $skillName) {

                DB::table('exercises_skills')->insert([
                    [
                        'exercise_id' =>    $this->getIdByName('exercises', $exerciseName),
                        'skill_id' =>       $this->getIdByName('skills', $skillName),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
        }
    }
}
