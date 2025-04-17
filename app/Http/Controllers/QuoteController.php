<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        /*
         * get the quotes
         * the company it's quoted for
         * the user that quoted it
         *
         * if the search bar has been used, filter with the value
         * */
        $quotes = Quote::with(['company:id,name', 'user:id,name'])
            ->select('id', 'user_id', 'company_id', 'quote_name', 'status', 'created_at')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('company', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                    $query->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                    $query->orWhere('quote_name', 'like', "%{$search}%");
                    $query->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(50);

        // check if the request is an AJAX call (for infinite scrolling)
        if ($request->ajax()) {
            // return quotes in JSON format
            return response()->json([
                'quotes' => $quotes,
            ]);
        }

        return view('quotes.quotes-index', [
            'quotes' => $quotes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
