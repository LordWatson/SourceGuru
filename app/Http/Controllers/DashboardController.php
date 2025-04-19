<?php

namespace App\Http\Controllers;

use App\Actions\Users\GetTopQuoteUsersAction;
use App\Enums\QuoteStatusEnum;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetTopQuoteUsersAction $getTopQuoteUsersAction)
    {
        $data = [];

        /*
         * eager load user, company
         * only grab their ids and names
         *
         * eager load products
         * only grab quote_id, unit_sell_price
         * u_s_p is required to call total_sell_price
         * */
        $quotes = Quote::with(['user:id,name', 'company:id,name', 'products:quote_id,total_sell_price'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();
        $quotes->makeVisible(['total_sell_price']);

        $data['quotes'] = $quotes;

        $data['totalQuotes'] = Quote::thisYear()->count();
        $data['totalQuotesChange'] = Quote::thisYear()->count() - Quote::lastYear()->count();
        $data['thisMonth'] = Quote::thisMonth()->count();
        $data['thisMonthChange'] = Quote::thisMonth()->count() - Quote::lastMonth()->count();
        $data['pendingQuotes'] = Quote::pending()->count();

        /*
         * cached query, reloads every 10 minutes
         *
         * get the 3 users with the most quotes created this month, that are not of a status of expired or rejected
         * */
        $data['quoteUsers'] = Cache::remember('dashboard_quote_users', 10, function () use($getTopQuoteUsersAction) {
            return $getTopQuoteUsersAction->execute(3);
        });

        return view('dashboard', compact('data'));
    }
}
