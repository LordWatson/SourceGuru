<?php

namespace App\Actions\Quotes;

use App\Models\Quote;

class FilterQuotesAction
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

    public function execute($filters, $search)
    {
        return Quote::with(['company:id,name', 'user:id,name'])
            ->select('id', 'user_id', 'company_id', 'quote_name', 'status', 'created_at')
            ->when(isset($filters['company']), fn($query) => $query->filterByCompany($filters['company']))
            ->when(isset($filters['user']), fn($query) => $query->filterByUser($filters['user']))
            ->when(isset($filters['status']), fn($query) => $query->filterByStatus($filters['status']))
            ->when(empty($filters) && $search, fn($query) => $query->search($search))
            ->orderBy('id', 'desc')
            ->paginate(50);
    }
}
