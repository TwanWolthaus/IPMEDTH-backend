<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'name' => 'De Zijl',
                'adress' => 'Paramaribostraat 66, Leiden',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'De Vliet A',
                'adress' => ' Voorschoterweg 6, Leiden',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'De Vliet B',
                'adress' => ' Voorschoterweg 6, Leiden',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'De Vliet A + B',
                'adress' => ' Voorschoterweg 6, Leiden',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
