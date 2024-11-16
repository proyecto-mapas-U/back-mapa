<?php

namespace config;
require '../vendor/autoload.php';  // Asegúrate de que Composer está configurado y has instalado phpdotenv

class Database
{
    private $host;
    private $user;
    private $pass;
    private $db;

    public function __construct()
    {
        $this->host = getenv('DB_HOST');
        # $this->user = getenv('DB_USER');
        $this->user = 'root';
        # $this->pass = getenv('DB_PASS');
        $this->pass = 'dcf.cfd.2005';
        # $this->db = getenv('DB_NAME');
        $this->db = 'mapa';
    }

    public function getConnection()
    {
        try {
            echo $this->host . " " . $this->user . " " . $this->pass . " " . $this->db;
            $conn = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->user, $this->pass);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return null;
        }
    }
}
