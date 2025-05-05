<?php

namespace App\Http\Controllers;

use App\Actions\Proposals\CreateProposalAction;
use App\Actions\Proposals\StoreProposalAction;
use App\Http\Requests\Proposals\CreateProposalRequest;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(CreateProposalRequest $request, StoreProposalAction $storeProposalAction, CreateProposalAction $createProposalAction)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the company action
        $storeProposal = $storeProposalAction->execute($validated['proposal'], $validated['quote_id']);

        if(!$storeProposal['success']) return Redirect::to("/quotes/{$validated['quote_id']}")->withErrors(['error' => 'Failed to store proposal']);

        unset($validated['proposal']);

        $action = $createProposalAction->execute(
            array_merge($validated, [
                'created_by' => Auth::id(),
                'url' => $storeProposal['url']
            ])
        );

        // handle error
        if(!$action['success']) return Redirect::to("/quotes/{$validated['quote_id']}")->withErrors(['error' => 'Failed to store proposal']);

        // return to the quote
        return Redirect::to("/quotes/{$validated['quote_id']}")
            ->with('status', [
                'type' => 'update',
                'message' => 'Proposal added',
                'colour' => 'green',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        //
    }
}
