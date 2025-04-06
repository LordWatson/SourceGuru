<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesArray = [
            [
                'name' => 'user',
                'description' => 'User can view, edit, and delete entities created by themselves.',
                'level' => 1,
            ],
            [
                'name' => 'admin',
                'description' => 'Admin can view, edit, and delete entities created by anyone.',
                'level' => 10123,
            ],
            [
                'name' => 'customer',
                'description' => 'Customer can view entities that are assigned to them.',
                'level' => 2,
            ]
        ];

        foreach($rolesArray as $role) {
            Role::create([
                'name' => $role['name'],
                'description' => $role['description'],
                'level' => $role['level'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
