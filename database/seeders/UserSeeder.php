<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create host users
        for ($i = 1; $i <= 4; $i++) {
            $student = User::create([
                'name' => "Host User {$i}",
                'email' => "host{$i}@gmail.com",
                'password' => Hash::make('password'),
            ]);
            $student->assignRole('host');
        }

        // Create users
        for ($i = 1; $i <= 2; $i++) {
            $teacher = User::create([
                'name' => "User {$i}",
                'email' => "user{$i}@gmail.com",
                'password' => Hash::make('password'),
            ]);
            $teacher->assignRole('user');
        }
    }
}
