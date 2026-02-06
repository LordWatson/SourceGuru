<?php

namespace App\Actions\QuoteItem;

use App\Models\Package;
use App\Models\PackageOption;

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
     * @param array $selectedOptions Array of package_option_id => product_id
     * @return array
     */
    public function execute(Package $package, int $quoteId, array $selectedOptions = []): array
    {
        $totalBuyPrice = 0;
        $totalSellPrice = 0;
        $squashedProducts = [];
        $selectedOptionsData = [];

        // if options are provided, use them
        if(!empty($selectedOptions)){
            foreach($selectedOptions as $optionId => $productId){
                $option = PackageOption::with(['products' => function($query) use ($productId) {
                    $query->where('products.id', $productId);
                }])->find($optionId);

                if($option && $option->products->isNotEmpty()){
                    $product = $option->products->first();
                    $buyPrice = $product->pivot->unit_buy_price ?? $product->unit_buy_price;
                    $sellPrice = $product->pivot->unit_sell_price ?? $product->unit_sell_price;

                    $totalBuyPrice += $buyPrice;
                    $totalSellPrice += $sellPrice;

                    $squashedProducts[] = [
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'unit_buy_price' => $buyPrice,
                        'unit_sell_price' => $sellPrice,
                        'qty' => 1,
                        'option_name' => $option->name,
                    ];

                    $selectedOptionsData[] = [
                        'option_id' => $optionId,
                        'option_name' => $option->name,
                        'product_id' => $productId,
                    ];
                }
            }
        }else{
            $package->load('products');
            $products = $package->products;

            foreach($products as $product){
                $buyPrice = $product->pivot->unit_buy_price ?? $product->unit_buy_price;
                $sellPrice = $product->pivot->unit_sell_price ?? $product->unit_sell_price;

                $totalBuyPrice += $buyPrice;
                $totalSellPrice += $sellPrice;

                $squashedProducts[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'unit_buy_price' => $buyPrice,
                    'unit_sell_price' => $sellPrice,
                    'qty' => 1,
                ];
            }
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
            'squashed_products' => json_encode($squashedProducts),
            'selected_options' => json_encode($selectedOptionsData),
        ];
    }
}
