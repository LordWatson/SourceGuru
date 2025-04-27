<?php

namespace App\Actions\Quotes;

use App\Actions\UpdateAction;
use App\Models\Quote;

class UpdateQuoteAction extends UpdateAction
{
    protected function getModelInstance(int $id): Quote
    {
        return Quote::findOrFail($id);
    }
}
