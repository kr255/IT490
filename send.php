#!/usr/bin/php

<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;

$connection = new AMQPStreamConnection('192.168.43.125', 5672, 'test1', '123', 'IT490');
$val=$argv[1];
#$chId = $connection->isConnected();
#echo "$chId";
if ($connection->isConnected() == 1 )
{
    echo "is connected, obtaining a channel " . PHP_EOL;
    $channel = $connection->channel();
    $channel->queue_declare("test1");
    
    $msg = new AMQPMessage("$val");
    $channel->basic_publish($msg, 'test', '');
    echo "published message $val, closing connection" . PHP_EOL;
    $channel->close();
    $connection->close();
    
}
else
{
    echo "did not connect, closing the connection".php_eol;
    $connection->close();
}

#$channel = $connection->channel();



?>