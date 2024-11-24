<?php
require_once '../config/Database.php';
require_once '../models/RespuestaRestDto.php';
require_once '../uc/LocalizacionUC.php';

$database = new \config\Database();
$db = $database->getConnection();

if ($db) {
    $localizador = new \uc\LocalizacionUC($db);
    $data = json_decode(file_get_contents("php://input"));
    $existeUsuario = $localizador->verificarExistencia($data->idUsuario);
    http_response_code(200);
    if ($existeUsuario > 0) {
        echo json_encode(new \models\RespuestaRestDto($existeUsuario, true, "Ya existe usuario con id " . $data->idUsuario));
    } else {
        $rta = new \models\RespuestaRestDto($existeUsuario, false, "No existe usuario con id " . $data->idUsuario);
        echo json_encode($rta->__toJson());
    }
}
