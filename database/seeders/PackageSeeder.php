<?php

namespace Database\Seeders;

use App\Actions\Packages\CreatePackageAction;
use App\Models\Package;
use App\Models\PackageVersion;
use App\Models\PackageVersionProduct;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(CreatePackageAction $createPackageAction): void
    {
        for($i = 0; $i < 50; $i++){
            $package = $createPackageAction->execute([
                'name' => fake()->words(3, true),
                'description' => fake()->sentence(),
                'status' => 'active',
            ]);

            $products = Product::inRandomOrder()
                ->take(rand(2, 6))
                ->select('id', 'unit_buy_price', 'unit_sell_price')
                ->get();

            $package['package']->products()->sync([1, 2, 3]);

            PackageVersion::create([
                'package_id' => $package['package']->id,
                'version_number' => '1',
            ]);

            foreach($products as $product){
                PackageVersionProduct::create([
                    'package_version_id' => 1,
                    'package_id' => $package['package']->id,
                    'product_id' => $product->id,
                    'unit_buy_price' => $product->unit_buy_price,
                    'unit_sell_price' => $product->unit_sell_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
