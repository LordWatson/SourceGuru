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
                'name' => 'super admin',
                'description' => 'Super Admin is given special privileges.',
                'level' => 10123,
            ],
            [
                'name' => 'admin',
                'description' => 'Admin can view, edit, and delete entities created by anyone.',
                'level' => 9932,
            ],
            [
                'name' => 'user',
                'description' => 'User can view, edit, and delete entities created by themselves.',
                'level' => 2,
            ],
            [
                'name' => 'customer',
                'description' => 'Customer can view entities that are assigned to them.',
                'level' => 1,
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
