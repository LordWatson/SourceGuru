<?php

namespace App\Http\Controllers;

use App\Actions\Quotes\CreateQuoteAction;
use App\Actions\Quotes\DuplicateQuoteAction;
use App\Actions\Quotes\FilterQuotesAction;
use App\Actions\Quotes\UpdateQuoteAction;
use App\Actions\Search\ParseSearchQueryAction;
use App\Enums\QuoteStatusEnum;
use App\Http\Requests\Quotes\CreateQuoteRequest;
use App\Http\Requests\Quotes\UpdateQuoteRequest;
use App\Models\Company;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
        $companies = Company::orderBy('name', 'asc')
            ->select('id', 'name')
            ->get();

        $statuses = QuoteStatusEnum::cases();

        return view('quotes.quote-create', compact([
            'companies',
            'statuses'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateQuoteRequest $request, CreateQuoteAction $createQuoteAction)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the quote action
        $action = $createQuoteAction->execute(array_merge($validated, ['user_id' => Auth::id()]));

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to create quote']);

        // redirect to the quotes show / edit page
        return Redirect::to("/quotes/{$action['quote']->id}")
            ->with('status', [
                'type' => 'create',
                'message' => 'Quote created',
                'colour' => 'green',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        $quote->load(['company:id,name', 'user:id,name', 'products', 'proposal:id,quote_id,signed_ip,url']);

        $statuses = QuoteStatusEnum::cases();

        return view('quotes.quotes-edit', [
            'quote' => $quote,
            'companies' => Company::orderBy('name', 'asc')->select('id', 'name')->get(),
            'users' => User::orderBy('name', 'asc')->select('id', 'name')->get(),
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuoteRequest $request, Quote $quote, UpdateQuoteAction $updateQuoteAction)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the update action
        $action = $updateQuoteAction->execute(array_merge($validated, ['id' => $quote->id]));

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to update quote.']);

        // redirect to the quote show / edit page
        return Redirect::to("/quotes/{$quote->id}")
            ->with('status', [
                'type' => 'update',
                'message' => 'Quote updated',
                'colour' => 'green',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        // delete the resource
        $quote->delete();

        // return to quotes index
        return Redirect::to('/quotes')
            ->with('status', [
                'type' => 'delete',
                'message' => 'Quote deleted',
                'colour' => 'red',
            ]);
    }

    /**
     * Duplicate the specified quote.
     */
    public function duplicate(Quote $quote, DuplicateQuoteAction $duplicateQuoteAction)
    {
        $action = $duplicateQuoteAction->execute($quote);

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to duplicate quote.']);

        // redirect to the quote show / edit page
        return Redirect::to("/quotes/{$action['quote']->id}")
            ->with('status', [
                'type' => 'update',
                'message' => 'Quote updated',
                'colour' => 'green',
            ]);
    }
}
