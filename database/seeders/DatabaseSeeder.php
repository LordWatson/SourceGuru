<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CompanySeeder::class,
            QuoteSeeder::class,
            QuoteItemSeeder::class,
            ProductTypeSeeder::class,
            ProductSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
