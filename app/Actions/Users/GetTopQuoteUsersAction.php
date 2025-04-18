<?php

namespace App\Actions\Users;

use App\Models\User;

class GetTopQuoteUsersAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * get $take number of users with the most quotes created this month, that are not of a status of expired or rejected
     * used to create Quotes Leaderboard
     *
     * @param int $take
     * @return mixed
     */
    public function execute(int $take): mixed
    {
        return User::select('id', 'name')
            ->withCount(['quotes as quotes_count' => function ($query) {
                $query->whereNotIn('status', ['expired', 'rejected'])
                    ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
            }])
            ->having('quotes_count', '>', 0)
            ->orderBy('quotes_count', 'desc')
            ->take($take)
            ->get();
    }
}
