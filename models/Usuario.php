<?php

namespace models;

class Usuario
{
private $nombre;
private $numero;

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function registro($db)
    {
        $stmt = $db->prepare("INSERT INTO usuarios (nombre_usuario, numero_contacto) VALUES (:nombre, :numero)");
        return $stmt->execute(['numero' => $this->numero, 'nombre' => $this->nombre]);
    }
}