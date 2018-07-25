#!/usr/bin/php

<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;
$timeout = 1;
$message = "hello world";
$connection = new AMQPStreamConnection('192.168.43.125', 5672, 'IT490', '12345', 'Login');

$chan_send = $connection->channel();
echo $chan_send->getChannelId() . PHP_EOL;

$chan_send->queue_declare('login_send', false, true, false, false);

$msg = new AMQPMessage($message, array('delivery_mode' => 2));
$chan_send->basic_publish($msg, '', 'login_send');
// $chan_rec = $connection->channel();
// echo $chan_rec->getChannelId() . PHP_EOL;
// 
// 
// $callback = function($msg){
// 
//                 echo $msg->body;
//                 };
// $chan_rec->basic_consume('login_recieve', '', false, false, false, false, $callback);
// 
// while(count($chan_rec->callbacks))
//      {
//         try{
//         $chan_rec->wait(null, false, $timeout);
//         }
//         catch(\PhpAmqpLib\Exception\AMQPTimeoutException $e)
//         {
//             $chan_rec->close();
//             $connection->close();
//             exit;
//         }
//      }
?>