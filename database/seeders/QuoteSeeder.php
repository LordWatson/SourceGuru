<?php

namespace Database\Seeders;

use App\Enums\QuoteStatusEnum;
use App\Models\Quote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $statusOptions = array_map(fn($status) => $status->value, QuoteStatusEnum::cases());

        for ($i = 0; $i < 1000; $i++) {

            /*
             * if the status = completed
             * add a completed date
             * and remove the expired date
             * */
            $status = $faker->randomElement($statusOptions);
            $expiredDate = $faker->optional()->dateTimeBetween('now', '+1 year');

            if($status == 'completed'){
                $completedDate = $faker->dateTimeBetween('-1 year', 'now');
                $expiredDate = null;
            }

            $createdDate = $faker->dateTimeBetween('-6 months', 'now');

            DB::table('quotes')->insert([
                'user_id' => $faker->numberBetween(2, 5),
                'company_id' => $faker->numberBetween(1, 10),
                'quote_name' => $faker->text(20),
                'completed_date' => $completedDate?->format('Y-m-d') ?? null,
                'expired_date' => $expiredDate?->format('Y-m-d') ?? null,
                'status' => $status,
                'notes' => $faker->optional()->text(),
                //'tax' => $faker->randomFloat(2, 0, 25),
                'created_at' => $createdDate,
                'updated_at' => now(),
            ]);
        }
    }
}
