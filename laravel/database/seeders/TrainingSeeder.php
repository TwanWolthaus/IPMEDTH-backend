<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TrainingSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('trainings')->insert([
            [
                'name' => "Voor Kinderen",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Voor Tieners",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Kleine Teams",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
