<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;

class rabbit{

private $connection;

public function __construct()
{

    $this->connection = new AMQPStreamConnection('192.168.43.125', 5672, 'IT490', '12345', 'Login');

     if ($this->connection->isConnected() == 1 )
    {
        echo "connected successfully " . PHP_EOL;
//         $this->chan_send = $this->connection->channel();
//         echo $this->chan_send->getChannelId() . PHP_EOL; // echos the channel id
        //$this->chan_send->queue_declare("err_logs", false, true, false, false); // declares queue on chan_send
    }
    else
    {
        //echo "did not connect to RMQ, closing the connection".php_eol;
        $this->connection->safeClose();
    }

}

public function sendmessage($message)
    {
        $channel_send = $this->connection-channel();
        $channel_send->queue_declare('login_send', false, true, false, false); // declares queue on chan_send
        $msg = new AMQPMessage($message, array('delivery_mode' => 2)); // presistent messages
        $channel_send->basic_publish($msg, '', 'login_send'); // 'err_logs'
        //echo "published message $message, closing connection" . PHP_EOL;
        //$this->chan_send->close();
        //$this->connection->close();
    }
    
}
?>