<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'fname' => 'Admin',
            'lname' => 'User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'number' => '0000000000',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
            'is_disabled' => false,
        ]);

        User::create([
            'name' => 'Default User',
            'fname' => 'Default',
            'lname' => 'User',
            'username' => 'user',
            'email' => 'user@example.com',
            'number' => '1111111111',
            'password' => Hash::make('user1234'),
            'role' => 'user',
            'is_disabled' => false,
        ]);
    }
}


