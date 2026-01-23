<?php

namespace App\Actions\QuoteItem;

use App\Models\Package;

class MapPackageToQuoteItemAction
{
    /**
     * Create the action.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Map a package to a quote item format
     *
     * @param Package $package
     * @param int $quoteId
     * @return array
     */
    public function execute(Package $package, int $quoteId): array
    {
        // load the current version with products
        $currentVersion = $package->currentVersion()->with('products')->first();

        if(!$currentVersion){
            throw new \Exception("Package has no current version set.");
        }

        // get all products from the current version
        $versionProducts = $currentVersion->products;

        // calculate totals from all products in the package
        $totalBuyPrice = 0;
        $totalSellPrice = 0;
        $totalEmissionBenchmark = 0;
        $totalEmissionResult = 0;
        $squashedProducts = [];

        foreach($versionProducts as $product){
            // Use prices from the pivot table (package_version_products)
            $buyPrice = $product->pivot->unit_buy_price ?? $product->unit_buy_price;
            $sellPrice = $product->pivot->unit_sell_price ?? $product->unit_sell_price;

            $totalBuyPrice += $buyPrice;
            $totalSellPrice += $sellPrice;
            $totalEmissionBenchmark += $product->emission_benchmark ?? 0.00;
            $totalEmissionResult += $product->emission_result ?? 0.00;

            // store product details for reference
            $squashedProducts[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'unit_buy_price' => $buyPrice,
                'unit_sell_price' => $sellPrice,
                'emission_benchmark' => $product->emission_benchmark ?? 0.00,
                'emission_result' => $product->emission_result ?? 0.00,
            ];
        }

        return [
            'quote_id' => $quoteId,
            'name' => $package->name,
            'description' => $package->description ?? 'Package',
            'unit_buy_price' => $totalBuyPrice,
            'unit_sell_price' => $totalSellPrice,
            'quantity' => 1,
            'product_type' => 'package',
            'product_source' => 'catalogue',
            'type_id' => $package->id,
            'emission_benchmark' => $totalEmissionBenchmark,
            'emission_result' => $totalEmissionResult,
            'squashed_products' => json_encode($squashedProducts),
        ];
    }
}
