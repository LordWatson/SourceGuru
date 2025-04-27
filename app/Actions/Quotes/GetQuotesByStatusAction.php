<?php

namespace App\Actions\Quotes;

use App\Models\Quote;
use Illuminate\Support\Collection;

class GetQuotesByStatusAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * get an array of unique status quotes, their count, and the percentage that count is of the total, inside a chosen period
     * eg
     * ['status' => 'Draft', 'count' => 30, 'percentage' => 20]
     *
     * @return Collection
     */
    public function execute(string $period = 'month'): Collection
    {
        $statusStats = Quote::statusStats('month')->get();

        // Calculate total for percentages
        $totalQuotes = $statusStats->sum('count');

        // Format data for chart
        return $statusStats->map(function ($item) use ($totalQuotes) {
            return [
                'status' => ucfirst($item->status),
                'count' => $item->count,
                'percentage' => $totalQuotes > 0 ? round(($item->count / $totalQuotes) * 100, 2) : 0,
            ];
        });
    }
}
