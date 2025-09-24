<?php

namespace App\Services;

use App\Contracts\Services\FulfillmentInterface;
use App\Models\Order;
use App\Models\OrderFulfillmentTask;
use App\Models\ProductFulfillmentStep;
use App\Models\TaskDependency;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class FulfillmentService implements FulfillmentInterface
{
    public function createTasks(Order $order): void
    {
        foreach($order->items as $item){
            $steps = ProductFulfillmentStep::where('product_id', $item->product_id)
                ->orderBy('step_order')
                ->get();

            $tasks = [];

            foreach($steps as $step){
                $tasks[] = OrderFulfillmentTask::create([
                    'order_id' => $order->id,
                    'order_item_id' => $item->id,
                    'fulfillment_step_id' => $step->fulfillment_step_id,
                    'step_order' => $step->step_order,
                    'status' => $step->step_order === 1 ? 'pending' : 'blocked',
                    'params' => $step->params,
                ]);
            }

            // build dependencies (configure_router depends on assign_ip)
            foreach($tasks as $task){
                if($task->step->key === 'configure_router'){
                    $assignIpTask = collect($tasks)->first(fn($t) => $t->step->key === 'assign_ip');

                    if($assignIpTask){
                        TaskDependency::create([
                            'task_id' => $task->id,
                            'depends_on_task_id' => $assignIpTask->id,
                        ]);
                    }
                }
            }
        }
    }

    public function dispatchPendingTasks(Order $order): void
    {
        $pendingTasks = OrderFulfillmentTask::where('order_id', $order->id)
            ->where('status', 'pending')
            ->get();

        foreach($pendingTasks as $task){
            $this->sendToQueue($task);
            $task->update(['status' => 'in_progress']);
        }
    }

    public function handleWorkerCallback(array $data): void
    {
        $task = OrderFulfillmentTask::findOrFail($data['task_id']);
        $task->update([
            'status' => $data['status'],
            'output' => $data['output'] ?? null,
        ]);

        if($data['status'] === 'success'){
            $this->unlockDependentTasks($task);
        }
    }

    protected function unlockDependentTasks(OrderFulfillmentTask $completedTask): void
    {
        $nextTasks = TaskDependency::where('depends_on_task_id', $completedTask->id)->pluck('task_id');

        foreach($nextTasks as $taskId){
            $task = OrderFulfillmentTask::find($taskId);

            $allDone = TaskDependency::where('task_id', $task->id)
                ->join('order_fulfillment_tasks', 'task_dependencies.depends_on_task_id', '=', 'order_fulfillment_tasks.id')
                ->where('order_fulfillment_tasks.status', '!=', 'success')
                ->count() === 0;

            if($allDone && $task->status === 'blocked'){
                $task->update(['status' => 'pending']);

                $this->sendToQueue($task);

                $task->update(['status' => 'in_progress']);
            }
        }
    }

    protected function sendToQueue(OrderFulfillmentTask $task): void
    {
        $connection = new AMQPStreamConnection('rabbitmq-host', 5672, 'user', 'password');

        $channel = $connection->channel();
        $channel->queue_declare('fulfillment', false, true, false, false);

        $payload = json_encode([
            'task_id' => $task->id,
            'order_id' => $task->order_id,
            'order_item_id' => $task->order_item_id,
            'step_key' => $task->step->key,
            'params' => $task->params,
        ]);

        $msg = new AMQPMessage($payload, ['delivery_mode' => 2]);
        $channel->basic_publish($msg, '', 'fulfillment');

        $channel->close();
        $connection->close();
    }
}
