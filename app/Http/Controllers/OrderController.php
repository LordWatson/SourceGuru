<?php

namespace App\Http\Controllers;

use App\Actions\Orders\CreateOrderAction;
use App\Models\Order;
use App\Services\FulfillmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
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
    public function store(Request $request, CreateOrderAction $createOrderAction, FulfillmentService $service)
    {
        // trigger the order action
        $action = $createOrderAction->execute(['quote_id' => $request->quote_id]);

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to create order']);

        // update the quote status
        $action['order']->quote->update(['status' => 'ordered']);

        /*
         * @see FulfillmentService
         * create the tasks to fulfill the order
         * dispatch the pending tasks to the queue (RabbitMQ)
         * */
        $service->createTasks($action['order']);
        $service->dispatchPendingTasks($action['order']);

        /*
         * redirect to the quotes show / edit page
         * this is temporary until we have a proper order page
         * */
        return Redirect::to("/quotes/$request->quote_id")
            ->with('status', [
                'type' => 'create',
                'message' => 'Order created',
                'colour' => 'green',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
