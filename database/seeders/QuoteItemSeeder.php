<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuoteItem;
use App\Models\Quote;
use Faker\Factory as Faker;

class QuoteItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // fetch all quote ids
        $quoteIds = Quote::pluck('id')->toArray();

        // seed 3000 quote items
        for ($i = 0; $i < 3000; $i++) {
            // randomly pick a quote_id
            $quoteId = $faker->randomElement($quoteIds);

            // random quantity between 1 and 100
            $quantity = $faker->randomNumber(2, true);

            // random unit buy price between 10 and 500
            $unitBuyPrice = $faker->randomFloat(2, 10, 500);

            // random unit sell price 10% to 50% higher than unit buy price
            $unitSellPrice = $unitBuyPrice * $faker->randomFloat(2, 1.1, 1.5);

            // emission_benchmark
            $emissionBenchmark = $faker->randomFloat(2, 0, 2);

            // emission_result only if emission_benchmark > 0
            $emissionResult = null;
            if ($emissionBenchmark > 0) {
                // emission_result is 10% to 50% of emission_benchmark
                $emissionResult = $faker->randomFloat(2, $emissionBenchmark * 0.1, $emissionBenchmark * 0.5);
            }

            QuoteItem::create([
                'quote_id' => $quoteId,
                'name' => $faker->word(),
                'description' => $faker->sentence(),
                'product_source' => $faker->word(),
                'quantity' => $quantity,
                'unit_buy_price' => $unitBuyPrice,
                'total_buy_price' => $quantity * $unitBuyPrice,
                'unit_sell_price' => $unitSellPrice,
                'total_sell_price' => $quantity * $unitSellPrice,
                'emission_benchmark' => $emissionBenchmark,
                'emission_result' => $emissionResult,
            ]);
        }
    }
}
