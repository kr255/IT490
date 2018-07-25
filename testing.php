#!/usr/bin/php

<?php
require_once('rabbitbak.php');
$channel = '';
$message = "hello world";
$queue = 'login_send';
$queue_rec = 'login_recieve';
$test1 = new rabbitbak('192.168.43.125', 'Login');

$x = $test1->get_channel($channel);

$test1->message($x, $message, $queue);
//$test1->process_message($x, $queue);

?>