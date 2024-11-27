<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../config/Database.php';
require_once '../uc/LocalizacionUC.php';
require_once '../models/RespuestaRestDto.php';
require_once '../models/CoordenadasDto.php';

// Lógica encargada de obtener las coordenadas globales

$database = new \config\Database();
$db = $database->getConnection();

if ($db) {
    $localizador = new \uc\LocalizacionUC($db);
    $coordenadas = $localizador->obtenerCoordenadasGlobales();
    header("Content-Type: application/json");
    if ($coordenadas != null) {
        http_response_code(200);
        $rta = new \models\RespuestaRestDto($coordenadas, true, "Coordenadas encontradas...");
    } else {
        http_response_code(401);
        $rta = new \models\RespuestaRestDto($coordenadas, false, "No se encontraron coordenadas...");
    }
    echo json_encode($rta->__toJson());
}