<?php

namespace App\Contracts\Services;

use App\Models\Order;

interface FulfillmentInterface
{
    public function createTasks(Order $order);

    public function dispatchPendingTasks(Order $order);

    public function handleWorkerCallback(array $data);
}
