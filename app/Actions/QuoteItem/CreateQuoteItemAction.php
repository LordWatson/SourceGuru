<?php

namespace App\Actions\QuoteItem;

use App\Actions\CreateAction;
use App\Models\QuoteItem;

class CreateQuoteItemAction extends CreateAction
{
    protected function createModelInstance(array $data): QuoteItem
    {
        return QuoteItem::create($data);
    }
}
