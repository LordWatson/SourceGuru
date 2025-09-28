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
            // skip bespoke products for now, we'll revisit later with a default set of steps
            if(!isset($item->type_id)) continue;

            $steps = ProductFulfillmentStep::with('dependencies')
                ->where('product_id', $item->type_id)
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
            foreach($steps as $step){
                if(empty($step->dependencies)) continue;

                foreach($step->dependencies as $dependency){
                    if(!isset($tasks[$dependency->depends_on_step_id])) continue;

                    TaskDependency::create([
                        'task_id' => $tasks[$dependency->id]->id,
                        'depends_on_task_id' => $tasks[$dependency->depends_on_step_id]->id,
                    ]);
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
        $connection = new AMQPStreamConnection(
            config('queue.connections.rabbitmq.host'),
            config('queue.connections.rabbitmq.port'),
            config('queue.connections.rabbitmq.user'),
            config('queue.connections.rabbitmq.pass'),
        );

        $channel = $connection->channel();
        $exchange = config('queue.connections.rabbitmq.exchange');
        $channel->queue_declare($exchange, false, true, false, false);

        $payload = json_encode([
            'task_id' => $task->id,
            'order_id' => $task->order_id,
            'order_item_id' => $task->order_item_id,
            'step_key' => $task->step->key,
            'params' => $task->params,
            // remove after testing
            'message_id' => 'ascew-1234567890',
            'occurred_at' => now(),
            'order' => [
                'id' => "$task->order_id",
                'product_type' => 'router',
            ],
        ]);

        $msg = new AMQPMessage($payload, ['delivery_mode' => 2]);
        $channel->basic_publish($msg, '', 'sourceguru.processor.queue');

        $channel->close();
        $connection->close();
    }
}
