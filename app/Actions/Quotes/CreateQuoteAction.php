<?php

namespace App\Actions\Quotes;

use App\Actions\CreateAction;
use App\Models\Quote;

class CreateQuoteAction extends CreateAction
{
    protected function createModelInstance(array $data): Quote
    {
        return Quote::create($data);
    }
}
