<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Make sure to import your Admin model

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin1234'), // You can hash the password
            'role' => 'admin',
        ]);

        Admin::create([
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('admin1234'),
            'role' => 'superadmin',
        ]);
    }
}
