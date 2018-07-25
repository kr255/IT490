<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Channel\AbstractChannel;

class rabbitbak{

private $connection;
//private $channel;
private $chan_recieve;

public function __construct($servername, $vhost)
{
    //$this->connection = new AMQPStreamConnection($servername, 5672, 'IT490', '12345', "err_log");
    $this->connection = new AMQPStreamConnection($servername, 5672, 'IT490', '12345', $vhost);

     if ($this->connection->isConnected() == 1 )
    {
        echo "connected to $servername successfully " . PHP_EOL;
        //$this->chan_send = $this->connection->channel();
        //echo $this->chan_send->getChannelId() . PHP_EOL; // echos the channel id
        //$this->chan_send->queue_declare("err_logs", false, true, false, false); // declares queue on chan_send
    }
    else
    {
        //echo "did not connect to RMQ, closing the connection".php_eol;
        $this->connection->safeClose();
    }

}
public function get_channel($channel)
{
    $channel = $this->connection->channel();
    echo $channel->getChannelId() . PHP_EOL; // echos the channel id
}


public function message($channel, $message, $queue)
    {
        
        $this->channel->queue_declare($queue, false, true, false, false); // declares queue on chan_send
        $msg = new AMQPMessage($message, array('delivery_mode' => 2)); // presistent messages
        $channel->basic_publish($msg, '', $queue); // 'err_logs'
        echo "published message $message, closing connection" . PHP_EOL;
        //$this->chan_send->close();
        //$this->connection->close();
    }
    

    
public function process_message($channel, $queue)
{   
    $message = '';
    //$this->chan_send = $this->connection->channel(); // gets a new channel to recieve messages on
    echo $this->channel->getChannelId() . PHP_EOL;
    
//     $callback = function($msg){ 
//             echo $msg->body . PHP_EOL;
//             $message = $msg->body;
//             //$message = json_decode($message);
//             //$this->message($message, $queue);
//             $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
//             };
    $callback = function($msg)
    { 
        echo $msg->body . PHP_EOL;
        $message = $msg->body;
            //$message = json_decode($message);
        $this->message($this->channel, $message, 'login_recieve');
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    };
    $this->channel->basic_consume($queue, '', false, false, false, false, $callback);
    
    while(count($this->channel->callbacks))
    {
        $this->channel->wait();
    }
        $this->channel->close();
        //$this->connection->close();
        
}
    
}

?>