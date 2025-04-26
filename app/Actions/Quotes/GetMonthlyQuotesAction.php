<?php

namespace App\Actions\Quotes;

use App\Enums\QuoteStatusEnum;
use App\Models\Quote;
use Carbon\Carbon;

class GetMonthlyQuotesAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * get an array indexed by month, and a count of the quotes in that month
     * eg
     * ['January' => 10, 'February' => 15]
     *
     * @return array
     */
    public function execute(): array
    {
        // current month as a number
        $currentMonth = now()->month;

        // all months
        $months = array_slice(
            [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            0,
            // only give us months up to the current month
            $currentMonth
        );

        // array of months range as keys and default counts as 0
        $monthlyCounts = array_fill_keys($months, 0);

        // quotes within the current year
        $quotesPerMonth = Quote::whereYear('created_at', now()->year)
            // remove expired or rejected quotes
            ->whereNotIn('status', [
                QuoteStatusEnum::Expired,
                QuoteStatusEnum::Rejected,
            ])
            ->get()
            ->groupBy(function ($quote) {
                // group by full month name
                return Carbon::parse($quote->created_at)->format('F');
            });

        // map grouped data to the monthlyCounts array
        foreach ($quotesPerMonth as $monthName => $quotes) {
            if (array_key_exists($monthName, $monthlyCounts)) {
                $monthlyCounts[$monthName] = $quotes->count();
            }
        }

        return $monthlyCounts;
    }
}
