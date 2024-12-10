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
        $tenantId = $queryArray['tenant_id'] ?? null;
    
        if ($tenantId) {
            if (isset($this->clients[$tenantId]) && $this->clients[$tenantId]->count() > 0) {
                $conn->send(json_encode(['error' => 'A connection for this tenant already exists.']));
                $conn->close();
                return;
            }
    
            $this->clients[$tenantId] = new \SplObjectStorage;
            $this->clients[$tenantId]->attach($conn);
            echo "Connection established for tenant {$tenantId}\n";
        } else {
            $conn->close();
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        $tenantId = $data['tenant_id'] ?? null;

        if ($tenantId && isset($this->clients[$tenantId])) {
            foreach ($this->clients[$tenantId] as $client) {
                $client->send(json_encode($data));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        foreach ($this->clients as $tenantId => $connections) {
            if ($connections->contains($conn)) {
                $connections->detach($conn);
                echo "Connection closed for tenant {$tenantId}\n";
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