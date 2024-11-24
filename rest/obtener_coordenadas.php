<?php

$database = new \config\Database();
$db = $database->getConnection();

if ($db) {
    $localizador = new \uc\LocalizacionUC($db);
    $data = json_decode(file_get_contents("php://input"));
    $coordenadas = $localizador->obtenerLocalizacionUsuario($data->id_usuario);
    if ($coordenadas) {
        http_response_code(200);
        echo json_encode($coordenadas);
    }
}
