<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class AgendaSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('agendas')->insert([
            [
                'team_id' => null,
                'name' => 'Algemene agenda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
