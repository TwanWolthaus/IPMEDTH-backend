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
        $exerciseOnTool = [
            'Wedstrijdje Onderduwen'        => [['Bal (per groep)', 1, true], ['Fluitje', 1, false]],
            'Lucht Happen En Ondertrekken'  => [['Bal (per persoon)', 2, false]],
        ];

        foreach ($exerciseOnTool as $exerciseName => $tools) {

            foreach ($tools as $tool) {

                DB::table('requirements')->insert([
                    [
                        'exercise_id' =>    $this->getIdByName('exercises', $exerciseName),
                        'tool_id' =>        $this->getIdByName('tools', $tool[0]),
                        'amount' =>         $tool[1],
                        'is_optional' =>    $tool[2],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
        }
    }
}
