<?php

namespace Database\Seeders;

use App\Models\Company;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 10 companies
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Company::create([
                'name' => $faker->company,
                'primary_contact_name' => $faker->name,
                'primary_contact_email' => $faker->companyEmail,
                'primary_contact_phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'account_manager_id' => rand(1, 4),
            ]);
        }
    }
}
