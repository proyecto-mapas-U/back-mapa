<?php

function construirCoordenadas($data): \models\CoordenadasDto
{
    $coordenadas = new \models\CoordenadasDto();
    $coordenadas->setIdUsuario($data->idUsuario);
    $coordenadas->setLatitude($data->latitud);
    $coordenadas->setLongitude($data->longitud);
    return $coordenadas;
}

$database = new \config\Database();
$db = $database->getConnection();

if ($db) {
    $localizador = new \uc\LocalizacionUC($db);
    $data = json_decode(file_get_contents("php://input"));
    $coordenadas = construirCoordenadas($data);
    $coordenadas = $localizador->enviarLocalizacion($coordenadas);
    if ($coordenadas) {
        http_response_code(200);
        echo json_encode($coordenadas);
    }
}

