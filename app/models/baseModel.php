<?php
namespace App\Models;

use PDO;
use PDOException;
use App\Models\Database;  

require_once MAIN_APP_ROUTE . "../models/Database.php";

abstract class BaseModel
{
    protected $dbConnection;
    protected $table;

    public function __construct()
    {
        // Obtenemos la conexión PDO de la clase Singleton Database
        $this->dbConnection = Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        try {
            $sql = "SELECT * FROM $this->table";
            $statement = $this->dbConnection->query($sql);
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $ex) {
            echo "Error al obtener todos los registros: " . $ex->getMessage();
            return [];
        }
    }
}
