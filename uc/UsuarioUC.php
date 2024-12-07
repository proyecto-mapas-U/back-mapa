<?php

namespace uc;

class UsuarioUC
{

    private $bd;

    function __construct($bd)
    {
        $this->bd = $bd;
    }

    public function buscarPorNumero($numeroUsuario)
    {
        $stmt = $this->bd->prepare("SELECT u.id AS id, u.nombre_usuario AS nombre FROM usuarios AS u WHERE u.numero_contacto = :num");
        $stmt->execute(['num' => $numeroUsuario]);
        return $stmt->fetch();
    }
}