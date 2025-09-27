<?php

namespace App\Actions\Orders;

use App\Actions\CreateAction;
use App\Models\Order;

class CreateOrderAction extends CreateAction
{
    protected function createModelInstance(array $data): Order
    {
        return Order::create($data);
    }
}
