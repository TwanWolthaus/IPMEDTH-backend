<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $this->call([

            // seed tables with no FK
            PermissionSeeder::class,
            CategorySeeder::class,
            LocationSeeder::class,
            TeamSeeder::class,
            ExerciseSeeder::class,
        ]);

        $this->call([

            // seed tables with FK
            UserSeeder::class,
            AgendaSeeder::class,
            SkillSeeder::class,
            TrainingSeeder::class,
            RequirementSeeder::class,
        ]);

        $this->call([

            // seed link tables
            ExerciseSkillSeeder::class,
            TrainingExerciseSeeder::class,
        ]);

    }
}
