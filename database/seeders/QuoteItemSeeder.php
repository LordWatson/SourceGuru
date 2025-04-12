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

        // seed 300 quote items
        for ($i = 0; $i < 300; $i++) {
            // randomly pick a quote_id
            $quoteId = $faker->randomElement($quoteIds);
            // random quantity between 1 and 100
            $quantity = $faker->randomFloat(2, 1, 100);
            // random unit buy price between 10 and 500
            $unitBuyPrice = $faker->randomFloat(2, 10, 500);
            // random unit sell price 10% to 50% higher than unit buy price
            $unitSellPrice = $unitBuyPrice * $faker->randomFloat(2, 1.1, 1.5);

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
            ]);
        }
    }
}
