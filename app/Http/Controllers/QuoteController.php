<?php

namespace App\Http\Controllers;

use App\Actions\Search\ParseSearchQueryAction;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ParseSearchQueryAction $searchAction)
    {
        $search = $request->input('search');
        $filters = $searchAction->execute($search);

        $quotes = Quote::with(['company:id,name', 'user:id,name'])
            ->select('id', 'user_id', 'company_id', 'quote_name', 'status', 'created_at')
            ->when(isset($filters['company']), function ($query) use ($filters) {
                $query->whereHas('company', function ($q) use ($filters) {
                    $q->where('name', 'like', "%{$filters['company']}%");
                });
            })
            ->when(isset($filters['user']), function ($query) use ($filters) {
                $query->whereHas('user', function ($q) use ($filters) {
                    $q->where('name', 'like', "%{$filters['user']}%");
                });
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                $query->where('status', 'like', "%{$filters['status']}%");
            })
            ->when(empty($filters), function ($query) use ($search) {
                if ($search) {
                    // Default fallback search if no filters like "company:" or "user:" are found
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
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(50);

        // check if the request is an AJAX call (for infinite scrolling)
        if ($request->ajax()) {
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
