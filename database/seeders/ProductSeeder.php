<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductSubtype;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('data/products.json'));
        $products = json_decode($json, 1);

        foreach($products as $product){
            /*
             * find the product (and sub) types
             * I could've added id's into the array to seed, but string names are easier for readability
             * */
            $productType = ProductType::where('name', $product['product_type_name'])->first();
            $productSubtype = ProductSubtype::where('name', $product['product_sub_type_name'])
                ->where('product_type_id', $productType->id)
                ->first();

            // create
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'image' => $product['image'] ?? null,
                'product_type_id' => $productType->id,
                'product_sub_type_id' => $productSubtype->id,
                'unit_buy_price' => $product['unit_buy_price'],
                'unit_sell_price' => $product['unit_sell_price'],
            ]);
        }
    }
}
