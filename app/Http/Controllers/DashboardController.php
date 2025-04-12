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

        $data['quotes'] = Quote::orderByDesc('id')->with(['company', 'user'])->paginate(5);
        $data['totalQuotes'] = Quote::count();
        $data['thisMonth'] = Quote::thisMonth()->count();
        $data['pendingQuotes'] = Quote::pending()->count();

        return view('dashboard', compact('data'));
    }
}
