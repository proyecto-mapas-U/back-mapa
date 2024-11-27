<?php

namespace models;

class CoordenadasDto
{
    private int $idUsuario;
    private string $latitud;
    private string $longitud;

    /**
     * @return string
     */
    public function getLatitud(): string
    {
        return $this->latitud;
    }

    /**
     * @param mixed $latitud
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;
    }

    /**
     * @return string
     */
    public function getLongitud(): string
    {
        return $this->longitud;
    }

    /**
     * @param mixed $longitud
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;
    }

    /**
     * @return int
     */
    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }


}