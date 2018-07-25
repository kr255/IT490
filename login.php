<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;

$connection = new AMQPStreamConnection('192.168.1.103', 5672, 'IT490', '12345', 'Login');
$chan_send = $connection->channel();
echo $chan_send->getChannelId() . PHP_EOL;
echo "hellow";

?>
