<?php

namespace MyMap;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
class SocketMap implements MessageComponentInterface
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