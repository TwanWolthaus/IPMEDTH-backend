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
            'Techniek' => ['Gooien-vangen', 'Polocrawl', 'Draai', 'Agility', 'Schieten', 'Fietsenbenen', 'Zwemtechniek'],
            'Tactiek' => ['Midvoor-midachter', 'Manmeer-manminder', 'Aanval', 'Verdediging', 'Heads-up', 'Wisselen', 'Wedstrijdstress'],
            'Conditie' => ['Ademhaling', 'Spieren', 'Cardio', 'Sprint'],
            'Cooling down' => ['Rekken'],
            'Keeper' => [],
            'Theorie' => ['Regels', 'Handgebaren-scheidsrechter', 'Overtredingen'],
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
