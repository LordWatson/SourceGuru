<?php

namespace App\Http\Controllers;

use App\Actions\Company\UpdateCompanyAction;
use App\Actions\QuoteItem\CreateQuoteItemAction;
use App\Actions\QuoteItem\MapCatalogueProductToQuoteItemAction;
use App\Actions\QuoteItem\UpdateQuoteItemAction;
use App\Http\Requests\QuoteItem\CreateQuoteItemRequest;
use App\Http\Requests\QuoteItem\UpdateQuoteItemRequest;
use App\Models\Product;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QuoteItemController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateQuoteItemRequest $request, CreateQuoteItemAction $createQuoteItemAction)
    {
        // validate the request
        $validated = $request->validated();

        // create action
        $action = $createQuoteItemAction->execute($validated);

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to add product.']);

        // redirect to the users show / edit page
        return Redirect::to("/quotes/{$action['quoteitem']->quote_id}")
            ->with('status', [
                'type' => 'create',
                'message' => 'Product added',
                'colour' => 'green',
            ]);
    }

    /**
     * Store a catalogue product.
     */
    public function addCatalogueProduct(Request $request, int $quoteId, MapCatalogueProductToQuoteItemAction $mapCatalogueProductToQuoteItemAction, CreateQuoteItemAction $createQuoteItemAction)
    {
        // validate the request
        $product = Product::findOrFail($request->product);

        // format the catalogue product into a manner that will be accepted by the createQuoteItemAction
        $quoteItem = $mapCatalogueProductToQuoteItemAction->execute($product, $quoteId);

        // create action
        $action = $createQuoteItemAction->execute($quoteItem);

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to add product.']);

        // redirect to the users show / edit page
        return Redirect::to("/quotes/{$action['quoteitem']->quote_id}")
            ->with('status', [
                'type' => 'create',
                'message' => 'Product added',
                'colour' => 'green',
            ]);
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
        return Redirect::to("/quotes/{$quoteItem->quote_id}")
            ->with('status', [
                'type' => 'update',
                'message' => 'Product updated',
                'colour' => 'green',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuoteItem $quoteItem)
    {
        $quoteId = $quoteItem->quote_id;

        // delete the resource
        $quoteItem->delete();

        // return to quote
        return Redirect::to("/quotes/{$quoteId}")->with('status', 'product-deleted')
            ->with('status', [
                'type' => 'delete',
                'message' => 'Product deleted',
                'colour' => 'red',
            ]);
    }

    /**
     * Duplicate the specified quote.
     */
    public function duplicate(QuoteItem $quoteItem, CreateQuoteItemAction $createQuoteItemAction)
    {
        // replicate the existing product
        $newQuoteItem = $quoteItem->replicate()->toArray();

        // unset some things we don't want copied over
        unset($newQuoteItem['id'], $newQuoteItem['completed_at'], $newQuoteItem['expired_date'], $newQuoteItem['created_at'], $newQuoteItem['updated_at']);

        // use the create quote item action to create the new product
        $action = $createQuoteItemAction->execute($newQuoteItem);

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to duplicate quote item.']);

        // redirect to the quote show / edit page
        return Redirect::to("/quotes/{$quoteItem->quote_id}")
            ->with('status', [
                'type' => 'update',
                'message' => 'Product duplicated',
                'colour' => 'green',
            ]);
    }
}
