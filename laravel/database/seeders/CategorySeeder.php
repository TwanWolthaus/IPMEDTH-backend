<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('category')->insert([
            [
                'name' => 'Warming up',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Techniek',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tactiek',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Conditie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cooling down',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Keeper',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Theorie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
