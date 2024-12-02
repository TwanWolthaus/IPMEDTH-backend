<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('dummy')->insert([
            ['name' => 'John Doe', 'age' => 25],
            ['name' => 'Jane Smith', 'age' => 30],
            ['name' => 'Alice Johnson', 'age' => 22],
        ]);

    }
}
