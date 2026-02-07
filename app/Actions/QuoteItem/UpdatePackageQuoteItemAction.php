<?php

namespace App\Actions\QuoteItem;

use App\Models\QuoteItem;

class UpdatePackageQuoteItemAction
{
    public function execute(array $data): array
    {
        try {
            $quoteItem = QuoteItem::findOrFail($data['id']);

            // Update squashed products
            $squashedProducts = $data['squashed_products'];

            // Calculate new totals
            $totalBuyPrice = 0;
            $totalSellPrice = 0;

            foreach ($squashedProducts as $product) {
                $qty = $product['qty'] ?? 1;
                $totalBuyPrice += ($product['unit_buy_price'] ?? 0) * $qty;
                $totalSellPrice += ($product['unit_sell_price'] ?? 0) * $qty;
            }

            // Update the quote item
            $quoteItem->squashed_products = $squashedProducts;
            $quoteItem->unit_buy_price = $totalBuyPrice;
            $quoteItem->unit_sell_price = $totalSellPrice;

            // Update selected options if provided
            if (isset($data['selected_options'])) {
                $quoteItem->selected_options = $data['selected_options'];
            }

            $quoteItem->save();

            return ['success' => true, 'quoteitem' => $quoteItem];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
