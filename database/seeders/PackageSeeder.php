<?php

namespace Database\Seeders;

use App\Actions\Packages\CreatePackageAction;
use App\Models\Package;
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
                ->pluck('id')
                ->toArray();

            $package['package']->products()->sync([1, 2, 3]);
        }
    }
}
