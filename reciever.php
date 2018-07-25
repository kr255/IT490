#!/usr/bin/php

<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;

$connection = new AMQPStreamConnection('192.168.43.125', 5672, 'test1', '123', 'IT490');
if ($connection->isConnected() == 1 )
{
    echo "is connected, obtaining a channel " . PHP_EOL;
    $channel = $connection->channel();
    $channel->queue_declare("test1");
}
else
{
    echo "did not connect, closing the connection".php_eol;
    $connection->close();
}

$callback = function($msg){ echo " [x] Received ", $msg->body, "\n";};

$channel->basic_consume('test1', '', false, false, false, false, $callback);
while(count($channel->callbacks)){
    $channel->wait();
}



?>