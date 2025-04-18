<?php

namespace App\Actions\Quotes;

use App\Models\Quote;
use Illuminate\Pagination\LengthAwarePaginator;

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

    /**
     * @param $filters
     * @param $search
     * @return LengthAwarePaginator
     */
    public function execute($filters, $search): LengthAwarePaginator
    {
        return Quote::with(['company:id,name', 'user:id,name'])
            ->select('id', 'user_id', 'company_id', 'quote_name', 'status', 'created_at')
            // if searchbar contains 'company=xxxx'
            ->when(isset($filters['company']), fn($query) => $query->filterByCompany($filters['company']))
            // if searchbar contains 'user=xxxx'
            ->when(isset($filters['user']), fn($query) => $query->filterByUser($filters['user']))
            // if searchbar contains 'status=xxxx'
            ->when(isset($filters['status']), fn($query) => $query->filterByStatus($filters['status']))
             // if the searchbar doesn't contain a target column, just a general search value
            ->when(empty($filters) && $search, fn($query) => $query->search($search))
            ->orderBy('id', 'desc')
            ->paginate(50);
    }
}
