<?php
declare(strict_types=1);

namespace uc;


use models\CoordenadasDto;

class LocalizacionUC
{

    private $bd;

    function __construct($bd)
    {
        $this->bd = $bd;
    }

    public function obtenerLocalizacionUsuario($id_usuario)
    {
        $stmt = $this->bd->prepare("SELECT * FROM coordenadas WHERE id_usuario = :id");
        return $stmt->execute(['id' => $id_usuario]);
    }

    public function enviarLocalizacion(CoordenadasDto $coordenadasDto)
    {
        $stmt = $this->bd->prepare("INSERT INTO coordenadas (id_usuario, latitud, longitud) VALUES (:id, :lat, :long)");
        return $stmt->execute(['id' => $coordenadasDto->getIdUsuario(), 'lat' => $coordenadasDto->getLatitude(), 'long' => $coordenadasDto->getLongitude()]);
    }

    public function verificarExistencia($id_usuario)
    {
        $stmt = $this->bd->prepare("SELECT COUNT(c.id_usuario) FROM coordenadas AS c WHERE c.id_usuario = :id");
        $stmt->execute(['id' => $id_usuario]);
        return $stmt->fetchColumn();
    }

    public function actualizarCoordenadas(CoordenadasDto $coordenadasDto)
    {

    }

}