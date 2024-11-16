<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Usuario.php';

$database = new \config\Database();
$db = $database->getConnection();
if ($db) {
    $usuario = new \models\Usuario($db);

    $data = json_decode(file_get_contents("php://input"));

    $usuario->setNumero($data->numero);
    $usuario->setNombre($data->nombre);

    if ($usuario->registro($db)) {
        http_response_code(200);
        echo json_encode(array("message" => "Logging in."));
    } else {

        http_response_code(401);
        echo json_encode(array("message" => "Unable to login."));
    }
}