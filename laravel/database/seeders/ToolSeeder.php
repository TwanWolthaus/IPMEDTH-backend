<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tool')->insert([
            [
                'name' => 'Fluitje',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
