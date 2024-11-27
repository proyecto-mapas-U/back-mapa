<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once '../config/Database.php';
include_once '../models/UsuarioDto.php';
include_once '../models/RespuestaRestDto.php';

// Lógica encargada de registrar un nuevo usuario

$database = new \config\Database();
$db = $database->getConnection();
if ($db) {
    $data = json_decode(file_get_contents("php://input"));
    $usuario = new \models\UsuarioDto($db);
    $usuario->setNumero($data->numero);
    $usuario->setNombre($data->nombre);

    header("Content-Type: application/json");
    http_response_code(200);
    $registro = $usuario->registro($db);
    if ($registro) {
        $id = $usuario->buscarId($db);
        if (!empty($id)) {
            $usuario->setId($id);
            $rta = new \models\RespuestaRestDto($usuario->__toJson(), true, "Registrado correctamente...");
        }
        else
            $rta = new \models\RespuestaRestDto($id, false, "No se pudo registrar...");
    } else
        $rta = new \models\RespuestaRestDto(false, false, "Ya existe usuario con número " . $usuario->getNumero());
    echo json_encode($rta->__toJson());
}