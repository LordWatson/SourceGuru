<?php

namespace App\Actions\QuoteItem;

use App\Actions\CreateActivityLog;
use App\Actions\UpdateAction;
use App\Models\QuoteItem;
use Illuminate\Database\Eloquent\Model;

class UpdatePackageQuoteItemAction extends UpdateAction
{
    /**
     * Execute the update package operation.
     */
    public function execute(array $data, string $message = 'Package updated successfully'): array
    {
        // get the record
        $model = $this->getModelInstance($data['id']);

        try {
            // begin a db transaction
            \DB::beginTransaction();

            // get the original data (used for the activity log)
            $originalData = $model->getOriginal();

            // calculate the new unit prices based on all products in the package
            $unitBuyPrice = 0;
            $unitSellPrice = 0;

            foreach($data['squashed_products'] as $product){
                $unitBuyPrice += ($product['qty'] ?? 0) * ($product['unit_buy_price'] ?? 0);
                $unitSellPrice += ($product['qty'] ?? 0) * ($product['unit_sell_price'] ?? 0);
            }

            // update the record with calculated prices
            $model->update([
                'squashed_products' => $data['squashed_products'],
                'unit_buy_price' => $unitBuyPrice,
                'unit_sell_price' => $unitSellPrice,
            ]);

            // log the success
            $this->logActivity(
                model: $model,
                originalData: $originalData,
                statusCode: 201,
                message: $message
            );

            // commit the changes
            \DB::commit();
        } catch (\Exception $e) {
            // undo the db transaction
            \DB::rollBack();

            // log the failure
            $this->logActivity(
                model: $model,
                originalData: $model->getOriginal() ?? null,
                statusCode: 500,
                message: $e->getMessage()
            );

            // return a failed message
            return [
                'success' => false
            ];
        }

        // success !!
        return [
            strtolower(class_basename($model)) => $model->fresh(),
            'success' => true,
        ];
    }

    protected function getModelInstance(int $id): Model
    {
        return QuoteItem::findOrFail($id);
    }
}
