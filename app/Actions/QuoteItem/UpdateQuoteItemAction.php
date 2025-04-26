<?php

namespace App\Actions\QuoteItem;

use App\Actions\ActivityLog\CreateActivityLog;
use App\Models\QuoteItem;
use Illuminate\Support\Facades\DB;

class UpdateQuoteItemAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CreateActivityLog $createActivityLog)
    {
        //
    }

    public function execute(array $data): array
    {
        // get the quote item
        $quoteItem = QuoteItem::findOrFail($data['id']);

        try {
            DB::beginTransaction();

            // remove the id from the data array
            unset($data['id']);

            // update the fields
            $originalData = $quoteItem->getOriginal();
            $quoteItem->update($data);

            // log the update activity
            $this->logActivity(quoteItem: $quoteItem, originalData: $originalData, statusCode: 201);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            // log the failed update
            $originalData = $quoteItem->getOriginal() ?? null;
            $this->logActivity(quoteItem: $quoteItem, originalData:  $originalData, statusCode: 500, message:  $e->getMessage());

            return [
                'success' => false
            ];
        }

        return [
            'quote_item' => $quoteItem->fresh(),
            'success' => true,
        ];
    }

    /**
     * Log User Activity.
     */
    private function logActivity(
        ?QuoteItem $quoteItem,
        ?array $originalData,
        int $statusCode,
        ?string $message = null
    ): void {
        $activityLog = [
            'model' => QuoteItem::class,
            'model_id' => $quoteItem?->id,
            'event' => 'update',
            'original' => $originalData ? json_encode($originalData) : null,
            'changes' => $quoteItem ? json_encode($quoteItem->getChanges()) : null,
            'status_code' => $statusCode,
            'message' => $message,
        ];

        $this->createActivityLog->execute($activityLog);
    }
}
