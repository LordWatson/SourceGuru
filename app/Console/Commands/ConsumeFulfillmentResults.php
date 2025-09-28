<?php
// app/Console/Commands/ConsumeFulfillmentResults.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Jobs\ProcessFulfillmentJob;

class ConsumeFulfillmentResults extends Command
{
    protected $signature = 'fulfillment:consume';
    protected $description = 'Consume fulfillment results from RabbitMQ';

    public function handle()
    {
        $connection = new AMQPStreamConnection(
            config('queue.connections.rabbitmq.host'),
            config('queue.connections.rabbitmq.port'),
            config('queue.connections.rabbitmq.user'),
            config('queue.connections.rabbitmq.pass'),
        );

        $channel = $connection->channel();
        $channel->queue_declare('sourceguru.results', false, true, false, false);

        $callback = function (AMQPMessage $msg){
            $data = json_decode($msg->body, true);

            if(!$data || !isset($data['task_id'], $data['status'])){
                $this->error("Invalid message format: {$msg->body}");

                return;
            }

            ProcessFulfillmentJob::dispatch($data);

            $this->info(" [x] Dispatched job for task {$data['task_id']}");
        };

        $channel->basic_consume('sourceguru.results', '', false, true, false, false, $callback);

        $this->info(" [*] Waiting for fulfillment results. To exit press CTRL+C");

        while($channel->is_open()){
            $channel->wait();
        }
    }
}
