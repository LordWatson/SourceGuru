<?php

namespace App\Actions\QuoteItem;

use App\Actions\UpdateAction;
use App\Models\QuoteItem;

class UpdateQuoteItemAction extends UpdateAction
{
    protected function getModelInstance(int $id): QuoteItem
    {
        return QuoteItem::findOrFail($id);
    }
}
