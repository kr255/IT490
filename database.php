#!/usr/bin/php
<?php
include_once ('rabbit.php');
require_once '/home/kamran/project/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;
$timeout = 1;
$login = new AMQPStreamConnection('192.168.43.125', 5672, 'IT490', '12345', 'Login');

//obtains a channel for error logging
$login_channel = $login->channel();
$login_channel_send = $login->channel();
// $login_channel->getChannelId() . PHP_EOL;
$login_channel->exchange_declare('login', 'direct', false, true, false);
$login_channel->queue_bind('login_send', 'login');


//$error_channel->queue_declare('login_send', false, true, false, false);

$callback = function($msg){
                            global $login_channel_send;
                            $login_channel_send->exchange_declare('login', 'direct', false, true, false);
                            $login_channel_send->queue_bind('login_recieve', 'login');
                            //echo $msg->body . PHP_EOL;
                            $message = json_decode($msg->body, true);
                            $message['uname'] = "KAMRANRRRRRrrrr";
                            $message = json_encode($message);
                            $mssg = new AMQPMessage($message, array('delivery_mode' => 2));
                            $login_channel_send->basic_publish($mssg, 'login_recieve');
                            //$login_channel_send->close();
                            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                            };

$login_channel->basic_consume('login_send', '', false, false, false, false, $callback);

while(count($login_channel->callbacks))
     {
        $login_channel->wait();
     }
     $login_channel->close();
     $login->close();
     //$login_channel->close();
     //$login->close();
// $servername = '192.168.43.125';
// $username = 'new';
// $password = 'pass'; 
// $database = 'it490';
// $vhost = 'err_log';
// $message = '';
// $rabbit_error = new rabbit($servername, $vhost);
// //$rabbit_process = new rabbit($servername, 'Login');
// $db = new mysqli($servername, $username, $password, $database);
// 
// if ($db->connect_error) {
//     
//     //die("Connection failed: " . $rabbit->message($db->connect_error) . PHP_EOL);
//     $rabbit_error->message($db->connect_error . PHP_EOL, 'err_logs');
//     die();
// }
// else
// {
//     // echo $rabbit->message("connected properly") . PHP_EOL;
//     echo "connects".PHP_EOL;
// }
// $connection2 = new AMQPStreamConnection('192.168.43.125', 5672, 'IT490', '12345', 'Login');
// //echo "hellow ";
// $chan_rec = $connection2->channel();
// //echo $chan_send->getChannelId() . PHP_EOL;
// $callback = function($msg){
//             $chan_rec = $connection2->channel();
//             //echo $msg->body . PHP_EOL;
//             $message = $msg->body;
//             $message = json_decode($message);
//             //print_r($message);
//             foreach($message as $k => $v)
//                 {
//                     echo "{$k} => {$v} " . PHP_EOL;
//                     $chan_send->queue_declare('login_recieve', false, true, false, false); // declares queue on chan_send
//                     $msg = new AMQPMessage($message, array('delivery_mode' => 2)); // presistent messages
//                     $chan_send->basic_publish($message, '', 'login_recieve'); // 'err_logs'
//                 }
//             //$this->message($message, 'login_recieve');
//             $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
//             };
//     $chan_rec->basic_consume('login_send', '', false, false, false, false, $callback);
//     
//     while(count($chan_rec->callbacks))
//     {
//         $chan_rec->wait();
//     }
//         $chan_rec->close();
//         $connection2->close();
?>
