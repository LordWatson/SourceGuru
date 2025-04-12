<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::orderByDesc('id')->with(['company', 'user'])->paginate(5);

        return view('dashboard', compact('quotes'));
    }
}
