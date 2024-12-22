<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require dirname(__DIR__) . '/vendor/autoload.php';

class NotificationServer implements MessageComponentInterface
{
    protected $clients = [];

    public function onOpen(ConnectionInterface $conn) {
        $queryParams = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryParams, $queryArray);
        $id = $queryArray['client_id'] ?? null;
    
        if ($id) {
            $this->clients[$id] = new \SplObjectStorage;
            $this->clients[$id]->attach($conn);
            echo "Connection established for client {$id}\n";
        } else {
            $conn->close();
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Invalid JSON received: {$msg}\n";
            return;
        }
    
        $id = $data['client_id'] ?? null;
        echo "Message received from client {$id}: " . json_encode($data) . "\n";
    
        if ($id && isset($this->clients[$id])) {
            foreach ($this->clients[$id] as $client) {
                $client->send(json_encode($data));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        foreach ($this->clients as $id => $connections) {
            if ($connections->contains($conn)) {
                $connections->detach($conn);
                echo "Connection closed for client {$id}\n";
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new NotificationServer()
        )
    ),
    8070
);

echo "WebSocket server running on ws://localhost:8070\n";
$server->run();