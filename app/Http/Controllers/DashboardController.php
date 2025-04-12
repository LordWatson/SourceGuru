<?php

namespace App\Http\Controllers;

use App\Enums\QuoteStatusEnum;
use App\Models\Quote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];

        // need to eager load products, so I can access the accessor
        $quotes = Quote::with(['user', 'company', 'products'])->paginate(5);
        // make visible total_sell_price
        $quotes->getCollection()->makeVisible(['total_sell_price']);
        $data['quotes'] = $quotes;

        $data['totalQuotes'] = Quote::count();
        $data['thisMonth'] = Quote::thisMonth()->count();
        $data['pendingQuotes'] = Quote::pending()->count();

        return view('dashboard', compact('data'));
    }
}
