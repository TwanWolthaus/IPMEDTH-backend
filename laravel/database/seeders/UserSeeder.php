<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('users')->insert([
            [
                'permission_id' => 1,
                'disabled' => false,
                'first_name' => 'Alize',
                'middle_name' => null,
                'last_name' => 'Pistidda',
                'email' => 'john.doe@example.com',
                'date_birth' => null,
                'gender' => 'F',
                'diploma' => null,
            ],
        ]);
    }
}
