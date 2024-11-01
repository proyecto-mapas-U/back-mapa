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

// Se crea loop de eventos
$loop = Factory::create();

// Se crea el servidor
$socket = new Server('0.0.0.0:9000', $loop);

$context = array(
    'local_cert' => '/etc/ssl/websocket/server.crt', // Ruta del certificado
    'local_pk' => '/etc/ssl/websocket/server.key', // Ruta de la llave privada
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true, // Permite el uso de certificados autofirmados
    'security_level' => 1,
    'disable_compression' => false,
    'SNI_enabled' => false,
    'ciphers' => 'ALL:@SSLV3:TLSv1+HIGH:!SSLv2:!MEDIUM:!LOW:!EXP:!ADH:!aNULL:!eNULL:!NULL', // Lista más permisiva de cifrados
);
try {
    // Se crea el servidor seguro con las opciones de contexto
    $socket = new Server('0.0.0.0:9000', $loop, array(
        'tls' => $context
    ));

    // Se crea el servidor seguro con las opciones de contexto
    $secureSocket = new SecureServer($socket, $loop, $context);

    // Se crea la instancia del servidor WebSocket
    $websocket = new WsServer(new index());

    $websocket->enableKeepAlive($loop, 10);

    $server = new IoServer(
        new HttpServer($websocket),
        $secureSocket,
        $loop
    );

    echo "Servidor Socket Seguro Iniciado en el puerto 9000\n";

    $loop->addTimer(0.001, function () {
        echo "Loop de eventos iniciado\n";
    });

    $server->run();

} catch (\Exception $e) {
    echo "Error al iniciar el servidor: {$e->getMessage()}\n";
}