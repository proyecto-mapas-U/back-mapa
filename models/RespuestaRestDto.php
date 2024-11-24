<?php
declare(strict_types=1);
namespace models;

class RespuestaRestDto
{
    private $data;
    private bool $success;
    private string $mensaje;

    public function __construct($data = null, bool $success = false, string $mensaje = '')
    {
        $this->data = $data;
        $this->success = $success;
        $this->mensaje = $mensaje;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function getMensaje(): string
    {
        return $this->mensaje;
    }

    public function setMensaje(string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    public function __toJson(): array
    {
        return array(
            'data' => $this->data,
            'success' => $this->success,
            'mensaje' => $this->mensaje
        );
    }
}