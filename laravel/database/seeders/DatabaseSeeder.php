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
            ToolSeeder::class,
            CategorySeeder::class,
            LocationSeeder::class,
            TeamSeeder::class,
        ]);

        $this->call([

            // seed tables with FK
            ExerciseSeeder::class,
            UserSeeder::class,
            AgendaSeeder::class,
            SkillSeeder::class,
        ]);

        $this->call([

            // seed link tables
            TrainingSeeder::class,
            TrainingTrainerSeeder::class,
            RequirementSeeder::class,
            ExerciseSkillSeeder::class,
        ]);

    }
}
