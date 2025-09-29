<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SendFulfillmentTaskToWorkerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
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

        $msg = new AMQPMessage(json_encode($this->payload), ['delivery_mode' => 2]);
        $channel->basic_publish($msg, '', 'sourceguru.processor.queue');

        $channel->close();
        $connection->close();
    }
}

