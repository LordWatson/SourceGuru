<?php

namespace App\Http\Controllers;

use App\Actions\Quotes\FilterQuotesAction;
use App\Actions\Search\ParseSearchQueryAction;
use App\Enums\QuoteStatusEnum;
use App\Models\Company;
use App\Models\Quote;
use App\Models\User;
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
        $quote->load(['company:id,name', 'user:id,name', 'products']);

        //dd($quote->total_sell_price, $quote->total_buy_price, $quote->revenue);

        return view('quotes.quotes-edit', [
            'quote' => $quote,
            'companies' => Company::orderBy('name', 'asc')->select('id', 'name')->get(),
            'users' => User::orderBy('name', 'asc')->select('id', 'name')->get(),
        ]);
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
