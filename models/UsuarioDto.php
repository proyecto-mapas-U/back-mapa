<?php

namespace models;

class UsuarioDto
{
    private string $nombre;
    private string $numero;
    private int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre(): string
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
     * @return string
     */
    public function getNumero(): string
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

    /**
     * Función encargada de registrar un nuevo usuario
     *
     * @param $db
     * @return bool true o false si la consulta se ejecutó correctamente
     */
    public function registro($db): bool
    {
        if ($this->buscarPorNumero($db) > 0) {
            return false;
        }
        $stmt = $db->prepare("INSERT INTO usuarios (nombre_usuario, numero_contacto) VALUES (:nombre, :numero)");
        return $stmt->execute(['numero' => $this->numero, 'nombre' => $this->nombre]);
    }

    /**
     * Función encargada de buscar un usuario por numero
     *
     * @param $db
     * @return int número de usuarios registrados con el número buscado
     */
    public function buscarPorNumero($db): int
    {
        $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE numero_contacto = :numero");
        $stmt->execute(['numero' => $this->numero]);
        return $stmt->fetchColumn();
    }

    public function buscarId($db): int
    {
        $stmt = $db->prepare("SELECT id FROM usuarios WHERE numero_contacto = :numero");
        $stmt->execute(['numero' => $this->numero]);
        return $stmt->fetchColumn();
    }

    public function __toJson(): array
    {
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'numero' => $this->numero
        );
    }
}