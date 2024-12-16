<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'name' => 'Admin',
                'can_alter_agendas' => true,
                'can_alter_trainings' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
