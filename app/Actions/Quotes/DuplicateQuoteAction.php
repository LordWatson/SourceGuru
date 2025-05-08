<?php

namespace App\Actions\Quotes;

use App\Actions\ActivityLog\CreateActivityLog;
use App\Actions\CreateAction;
use App\Actions\QuoteItem\CreateQuoteItemAction;
use App\Models\Quote;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DuplicateQuoteAction
{
    public function __construct(
        protected CreateActivityLog $createActivityLog,
        protected CreateQuoteItemAction $createQuoteItemAction
    )
    {
        //
    }

    /**
     * Execute the create operation.
     */
    public function execute(Quote $quote): array
    {
        // replicate the existing quote
        $data = $quote->replicate()->toArray();

        // make a new name
        $data['quote_name'] = $data['quote_name'] . ' (copy)';

        // unset some things we don't want copied over
        unset($data['id'], $data['completed_at'], $data['expired_date'], $data['created_at'], $data['updated_at']);

        try {
            // begin a db transaction
            DB::beginTransaction();

            // create the new model record
            $newQuote = Quote::create($data);

            // log the creation success
            $this->logActivity(
                model: $newQuote,
                statusCode: 201,
                quote: $quote,
            );

            // duplicate the products on the quote
            if ($quote->products->isNotEmpty()) {
                // loop the products
                foreach ($quote->products as $item) {
                    // replicate the existing product
                    $newItem = $item->replicate()->toArray();

                    // the id should be the new quote id
                    $newItem['quote_id'] = $newQuote->id;

                    // create the quote item using the createQuoteItemAction
                    $this->createQuoteItemAction->execute($newItem);
                }
            }

            // commit the transaction
            DB::commit();

        } catch (Exception $e) {
            // undo the db transaction
            DB::rollBack();

            // log the failure
            $this->logActivity(
                model: null,
                statusCode: 500,
                quote: $quote,
            );

            // return a failed message
            return [
                'success' => false
            ];
        }

        // success !!
        return [
            'quote' => $newQuote->fresh(),
            'success' => true,
        ];
    }

    /**
     * Log Activity
     */
    protected function logActivity(
        ?Model $model,
        int $statusCode,
        Quote $quote
    ): void {
        $activityLog = [
            'model' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'event' => 'duplicate',
            'changes' => $model ? json_encode($model->getAttributes()) : null,
            'status_code' => $statusCode,
            'message' => "Record {$quote->id} duplicated successfully",
        ];

        $this->createActivityLog->execute($activityLog);
    }
}
