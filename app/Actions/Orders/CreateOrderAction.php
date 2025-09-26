<?php

namespace App\Actions\Orders;

use App\Actions\ActivityLog\CreateActivityLog;
use App\Actions\CreateAction;
use App\Models\Order;
use App\Services\FulfillmentService;

class CreateOrderAction extends CreateAction
{
    public function __construct(
        CreateActivityLog $createActivityLog,
        protected FulfillmentService $service
    ) {
        parent::__construct($createActivityLog);
    }

    protected function createModelInstance(array $data): Order
    {
        $order = Order::create([
            'quote_id' => $data['quote_id'],
            'status' => 'new',
        ]);

        // update the quote status
        $order->quote->update(['status' => 'ordered']);

        /*
         * @see FulfillmentService
         * create the tasks to fulfill the order
         * dispatch the pending tasks to the queue (RabbitMQ)
         * */
        $this->service->createTasks($order);
        $this->service->dispatchPendingTasks($order);

        return $order;
    }
}
