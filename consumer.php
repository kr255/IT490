#!/usr/bin/php
<?php
include_once ('rabbit.php');

$servername = '192.168.1.103';
$username = 'new';
$password = 'pass'; 
$database = 'it490';
$vhost = 'err_log';
$queue = 'err_logs';
$rabbit = new rabbit($servername, $vhost);

//$callback = function($msg){ echo " [x] Received ", $msg->body, "\n";};
$rabbit->getmessage($queue);

?>