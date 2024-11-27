<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../config/Database.php';
require_once '../uc/LocalizacionUC.php';
require_once '../models/CoordenadasDto.php';
require_once '../models/RespuestaRestDto.php';

// Lógica encargada de actualizar las coordenadas del usuario

$database = new \config\Database();
$db = $database->getConnection();

function construirCoordenadas($data): \models\CoordenadasDto
{
    $coordenadas = new \models\CoordenadasDto();
    $coordenadas->setIdUsuario($data->idUsuario);
    $coordenadas->setLatitud($data->latitud);
    $coordenadas->setLongitud($data->longitud);
    return $coordenadas;
}

if ($db) {
    $localizador = new \uc\LocalizacionUC($db);
    $data = json_decode(file_get_contents("php://input"));
    $coordenadas = construirCoordenadas($data);
    $coordActualizadas = $localizador->actualizarCoordenadas($coordenadas);
    header("Content-Type: application/json");
    if ($coordActualizadas) {
        http_response_code(200);
        $rta = new \models\RespuestaRestDto($coordActualizadas, true, "Coordenadas actualizadas con éxito...");
    } else {
        http_response_code(401);
        $rta = new \models\RespuestaRestDto($coordenadas, false, "No se pudieron actualizar las coordenadas...");
    }
    echo json_encode($rta->__toJson());
}