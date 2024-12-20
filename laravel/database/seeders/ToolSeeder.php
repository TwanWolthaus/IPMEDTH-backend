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
        DB::table('tools')->insert([
            [
                'name' => 'Fluitje',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bal (per groep)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bal (per paar)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bal (per persoon)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
