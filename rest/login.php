<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once '../config/Database.php';
include_once '../models/UsuarioDto.php';
include_once '../models/RespuestaRestDto.php';
include_once '../uc/UsuarioUC.php';

// Lógica encargada de iniciar sesión un usuario

$database = new \config\Database();
$db = $database->getConnection();
if ($db) {
    $usuarioUC = new \uc\UsuarioUC($db);
    $data = json_decode(file_get_contents("php://input"));
    $logueado = $usuarioUC->buscarPorNumero($data);
    header("Content-Type: application/json");
    if ($logueado != null) {
        http_response_code(200);
        $rta = new \models\RespuestaRestDto($logueado, true, "Bienvenido " . $logueado["nombre"]);
    } else {
        http_response_code(401);
        $rta = new \models\RespuestaRestDto($data->numero, false, "No logueado...");
    }
    echo json_encode($rta->__toJson());
}