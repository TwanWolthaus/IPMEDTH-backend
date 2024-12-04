<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exercises')->insert([
            'title' => 'hete aardappel',
            'description' => 'de aardappel is heet',
            'category' => 'gooien',
        ]);

        DB::table('exercises')->insert([
            'title' => 'koude aardappel',
            'description' => 'de aardappel is koud',
            'category' => 'gooien',
        ]);

        DB::table('exercises')->insert([
            'title' => 'ik weet niks',
            'description' => 'figma',
            'category' => 'warming up',
        ]);
    }
}
