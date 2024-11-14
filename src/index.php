<?php

namespace MyMap;
require __DIR__ . '/../vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\SecureServer;
use React\Socket\Server;
use React\EventLoop\Factory;

class index implements MessageComponentInterface
{

    protected $clientes;

    public function __construct()
    {
        $this->clientes = new \SplObjectStorage;
        echo "Iniciando Servidor de Sockets...\n";
    }

    function onOpen(ConnectionInterface $conn)
    {
        $this->clientes->attach($conn); // Almacena la nueva conexión para interactuar con el cliente más tarde
        echo "Nueva Conexión => ({$conn->resourceId})\n";
    }

    function onClose(ConnectionInterface $conn)
    {
        $this->clientes->detach($conn);
        echo "Cierre de Conexión => ({$conn->resourceId})\n";
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error de Conexión => ({$conn->resourceId})\n";
        $conn->close();
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        echo "{$from->resourceId} dice => {$msg}\n";
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new index()
        )
    ),
    9000,
    '0.0.0.0'
);
$server->run();


//$context = [
//    'local_cert' => '/etc/ssl/websocket/server.crt',
//    'local_pk' => '/etc/ssl/websocket/server.key',
//    'allow_self_signed' => true,
//    'verify_peer' => false,
//];
//
//// Se crea loop de eventos
//$loop = Factory::create();
//
//// Se crea el servidor
//$socket = new Server('0.0.0.0:9001', $loop);
//$secureSocket = new SecureServer($socket, $loop, $context);
//$websocket = new WsServer(new index());
//$websocket->enableKeepAlive($loop, 10);
//
//$server = new IoServer(
//    new HttpServer($websocket),
//    $secureSocket,
//    $loop
//);

echo "Servidor Socket Seguro Iniciado...";

$server->run();

