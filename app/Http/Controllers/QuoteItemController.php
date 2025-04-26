<?php

namespace App\Http\Controllers;

use App\Actions\Company\UpdateCompanyAction;
use App\Actions\QuoteItem\UpdateQuoteItemAction;
use App\Http\Requests\QuoteItem\UpdateQuoteItemRequest;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QuoteItemController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuoteItemRequest $request, QuoteItem $quoteItem, UpdateQuoteItemAction $updateQuoteItemAction)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the user action
        $action = $updateQuoteItemAction->execute(array_merge($validated, ['id' => $quoteItem->id]));

        // handle error
        if(!$action['success']) return Redirect::to("/quotes/{$quoteItem->quote_id}")
            ->withErrors([
                'error' => 'Failed to update product.'
            ]);

        // redirect to the quote show / edit page
        return Redirect::to("/quotes/{$quoteItem->quote_id}")->with('status', 'product-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuoteItem $quoteItem)
    {
        //
    }
}
