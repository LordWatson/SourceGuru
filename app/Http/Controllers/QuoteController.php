<?php

namespace App\Http\Controllers;

use App\Actions\Quotes\FilterQuotesAction;
use App\Actions\Search\ParseSearchQueryAction;
use App\Enums\QuoteStatusEnum;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ParseSearchQueryAction $searchAction, FilterQuotesAction $filterAction)
    {
        /*
         * eg. 'Nike'
         * Or
         * eg. 'company=Nike user=admin status=sent'
         * */
        $search = $request->input('search');

        /*
         * search action returns an array of the filters / search query the user has input
         * eg. ['user' => 'admin', 'status' => 'sent']
         * */
        $filters = $searchAction->execute($search);

        /*
         * filter action returns a paginated collection of the Quotes with the filters / search query (if any) applied
         * the action uses scopes in applied in ->when method
         * */
        $quotes = $filterAction->execute($filters, $search);

        /*
         * load more quotes on this infinite scroll table
         * */
        if ($request->ajax()) {
            return response()->json([
                'quotes' => $quotes,
            ]);
        }

        return view('quotes.quotes-index', [
            'quotes' => $quotes,
            'statuses' => QuoteStatusEnum::cases()
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
