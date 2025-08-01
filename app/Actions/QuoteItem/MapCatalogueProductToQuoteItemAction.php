<?php

namespace App\Actions\QuoteItem;

use App\Models\Product;

class MapCatalogueProductToQuoteItemAction
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
     * @param Product $catalogueProduct
     * @param int $quoteId
     * @return array
     */
    public function execute(Product $catalogueProduct, int $quoteId): array
    {
        return [
            'quote_id' => $quoteId,
            'name' => $catalogueProduct->name,
            'description' => $catalogueProduct->description,
            'unit_buy_price' => $catalogueProduct->unit_buy_price,
            'unit_sell_price' => $catalogueProduct->unit_sell_price,
            'quantity' => 1,
            'product_type' => 'catalogue',
            'product_source' => $catalogueProduct->source,
            'type_id' => $catalogueProduct->id,
            'emission_benchmark' => $catalogueProduct->emission_benchmark ?? 0.00,
            'emission_result' => $catalogueProduct->emission_result ?? 0.00,
        ];
    }
}
