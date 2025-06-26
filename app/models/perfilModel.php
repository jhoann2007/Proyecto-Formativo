<?php
namespace App\Models;

$idUsuario = $_SESSION['user_id'] ?? 'desconocido';

require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use PDO;
use PDOException;

class PerfilModel extends BaseModel
{
    public function __construct(
        private ?int $id = null,
        private ?string $nombre = null,
        private ?string $tipoDocumento = null,
        private ?string $documento = null,
        private ?string $fechaNacimiento = null,
        private ?string $email = null,
        private ?string $genero = null,
        private ?string $estado = null,
        private ?string $telefono = null,
        private ?string $eps = null,
        private ?string $tipoSangre = null,
        private ?string $telefonoEmergencia = null,
        private ?string $password = null,
        private ?string $observaciones = null
    ) {
        //Se llama al constructor del padre
        parent::__construct();
        //Se especifica la tabla 
        $this->table = "usuario";
    }

    public function getAllUser(): array
    {
        try {
            $sql = "SELECT * FROM usuario";
            $statement = $this->dbConnection->query($sql);
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $ex) {
            echo "Error al obtener todos los registros: " . $ex->getMessage();
            return [];
        }
    }
}
