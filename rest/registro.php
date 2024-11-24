<?php

include_once '../config/Database.php';
include_once '../models/UsuarioDto.php';

$database = new \config\Database();
$db = $database->getConnection();
if ($db) {
    $usuario = new \models\UsuarioDto($db);

    $data = json_decode(file_get_contents("php://input"));

    $usuario->setNumero($data->numero);
    $usuario->setNombre($data->nombre);

    if ($usuario->registro($db)) {
        http_response_code(200);
        echo json_encode(array("message" => "Registrado correctamente..."));
    } else {

        http_response_code(401);
        echo json_encode(array("message" => "Unable to login."));
    }
}