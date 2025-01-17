<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

use App\Enums\Role;

use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role' => Role::Admin->value,
                'password' => Hash::make("ikbenadmin"),
                'disabled' => false,
                'first_name' => 'Alize',
                'middle_name' => null,
                'last_name' => 'Pistidda',
                'email' => 'admin@example.com',
                'date_birth' => null,
                'gender' => 'F',
                'diploma' => null,
            ],
            [
                'role' => Role::Trainer->value,
                'password' => Hash::make("ikbentrainer"),
                'disabled' => false,
                'first_name' => 'Alize',
                'middle_name' => null,
                'last_name' => 'Pistidda',
                'email' => 'trainer@example.com',
                'date_birth' => null,
                'gender' => 'F',
                'diploma' => null,
            ],
            [
                'role' => Role::Guest->value,
                'password' => Hash::make("ikbenguest"),
                'disabled' => false,
                'first_name' => 'Alize',
                'middle_name' => null,
                'last_name' => 'Pistidda',
                'email' => 'guest@example.com',
                'date_birth' => null,
                'gender' => 'F',
                'diploma' => null,
            ],
        ]);
    }
}
