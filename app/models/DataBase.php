<?php
namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    // Constructor privado para evitar instanciación externa
    private function __construct()
    {
        $dbConfig = require_once MAIN_APP_ROUTE . "../config/database.php";
        try {
            $dsn = "{$dbConfig['driver']}:host={$dbConfig['host']};dbname={$dbConfig['database']}";
            $this->connection = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    // Método para obtener la única instancia de Database
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Método para obtener la conexión PDO
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    // Evitar clonación
    private function __clone() {}

    // Evitar unserialización
    // private function __wakeup() {}
}
