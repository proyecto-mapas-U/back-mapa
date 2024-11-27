<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../config/Database.php';
require_once '../models/RespuestaRestDto.php';
require_once '../uc/LocalizacionUC.php';

// Lógica encargada de verificar si un usuario ya existe con coordenadas

$database = new \config\Database();
$db = $database->getConnection();

if ($db) {
    $localizador = new \uc\LocalizacionUC($db);
    $data = json_decode(file_get_contents("php://input"));
    $existeUsuario = $localizador->verificarExistencia($data->idUsuario);
    header("Content-Type: application/json");
    http_response_code(200);
    if ($existeUsuario > 0)
        $rta = new \models\RespuestaRestDto($existeUsuario, true, "Ya existe usuario con id " . $data->idUsuario);
    else
        $rta = new \models\RespuestaRestDto($existeUsuario, false, "No existe usuario con id " . $data->idUsuario);
    echo json_encode($rta->__toJson());
}
