<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use PhpAmqpLib\Connection\AMQPStreamConnection;


class RabbitmqListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection('dev_rabbitmq', 5672, 'amanda', 'drugovich');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Message Received: ', $msg->body, "\n";
        };
          
        $channel->basic_consume('hello', '', false, true, false, false, $callback);
          
        while ($channel->is_open()) {
              $channel->wait();
        }

        return Command::SUCCESS;
    }
}
