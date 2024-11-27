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

    /**
     * Función encargada de obtener las coordenadas del usuario registrado
     *
     * @param $id_usuario
     * @return mixed coordenadas del usuario registrado
     */
    public function obtenerLocalizacionUsuario($id_usuario)
    {
        $stmt = $this->bd->prepare("SELECT * FROM coordenadas WHERE id_usuario = :id");
        $stmt->execute(['id' => $id_usuario]);
        return $stmt->fetch();
    }

    /**
     * Función encargada de registrar las coordenadas del usuario por primera vez
     *
     * @param CoordenadasDto $coordenadasDto
     * @return bool true o false si la consulta se ejecutó correctamente
     */
    public function enviarLocalizacion(CoordenadasDto $coordenadasDto): bool
    {
        $stmt = $this->bd->prepare("INSERT INTO coordenadas (id_usuario, latitud, longitud) VALUES (:id, :lat, :long)");
        return $stmt->execute(['id' => $coordenadasDto->getIdUsuario(), 'lat' => $coordenadasDto->getLatitud(), 'long' => $coordenadasDto->getLongitud()]);
    }

    /**
     * Función encargada de verificar si ya existe un usuario con coordenadas registradas
     *
     * @param $id_usuario
     * @return int número de identificadores encontrados
     */
    public function verificarExistencia($id_usuario): int
    {
        $stmt = $this->bd->prepare("SELECT COUNT(c.id_usuario) FROM coordenadas AS c WHERE c.id_usuario = :id");
        $stmt->execute(['id' => $id_usuario]);
        return $stmt->fetchColumn();
    }

    public function actualizarCoordenadas(CoordenadasDto $coordenadasDto): bool
    {
        $stmt = $this->bd->prepare("UPDATE coordenadas SET latitud = :lat, longitud = :long WHERE id_usuario = :id");
        return $stmt->execute(['id' => $coordenadasDto->getIdUsuario(), 'lat' => $coordenadasDto->getLatitud(), 'long' => $coordenadasDto->getLongitud()]);
    }

    public function obtenerCoordenadasGlobales()
    {
        $stmt = $this->bd->prepare("SELECT * FROM coordenadas");
        $stmt->execute();
        return $stmt->fetchAll();
    }

}