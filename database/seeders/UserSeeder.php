<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@user.com',
                'role_id' => 2,
            ],
            [
                'name' => 'Standard User',
                'email' => 'standard@user.com',
                'role_id' => 3,
            ],
            [
                'name' => 'Customer User',
                'email' => 'customerd@user.com',
                'role_id' => 4,
            ],
        ];

        foreach ($users as $userData) {
            User::create(array_merge($userData, [
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Create 10 standard users
        User::factory(10)->create(['role_id' => 3]);
    }
}
