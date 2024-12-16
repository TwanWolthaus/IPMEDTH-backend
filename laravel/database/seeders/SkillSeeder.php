<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class SkillSeeder extends Seeder
{

    public function getCategoryId($name): int
    {
        return DB::table('categories')->where('name', $name)->value('id');
    }

    public function run(): void
    {

        $skillsOnCategory = [
            'Warming up' => ['Rekken', 'Cardio'],
            'Techniek' => ['Gooien-Vangen', 'Polocrawl', 'Draai', 'Agility', 'Schieten', 'Fietsenbenen', 'Zwemtechniek'],
            'Tactiek' => ['Midvoor-Midachter', 'Manmeer-Manminder', 'Aanval', 'Verdediging', 'Heads-Up', 'Wisselen', 'Wedstrijdstress'],
            'Conditie' => ['Ademhaling', 'Spieren', 'Cardio', 'Sprint'],
            'Cooling down' => ['Rekken'],
            'Keeper' => [],
            'Theorie' => ['Regels', 'Handgebaren-Scheidsrechter', 'Overtredingen'],
        ];


        foreach ($skillsOnCategory as $categoryName => $skillNames) {

            $categoryId = $this->getCategoryId($categoryName);

            foreach ($skillNames as $skillName) {

                DB::table('skills')->insert([
                    'category_id' => $categoryId,
                    'name' => $skillName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
};
