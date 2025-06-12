<?php
namespace App\Models;
require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use DateTime;
use PDO;
use PDOException;

class AgregarEntrenadorModel extends BaseModel
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
        $this->table = "entrenadores";
    }

    public function save() {
        try {
            // Verificar si hay un ID disponible
            $nextId = $this->getNextId();
            
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("INSERT INTO $this->table (id, nombre, tipoDocumento, documento, fechaNacimiento, email, genero, estado, telefono, eps, tipoSangre, telefonoEmergencia, password, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            # 2. Se reemplazan las variables con bindParam
            # ID
            $sql->bindParam(1, $nextId, PDO::PARAM_INT);
            # Nombre
            $sql->bindParam(2, $this->nombre, PDO::PARAM_STR);
            # Tipo Documento
            $sql->bindParam(3, $this->tipoDocumento, PDO::PARAM_STR);
            # Documento
            $sql->bindParam(4, $this->documento, PDO::PARAM_STR);
            # Fecha Nacimiento
            $sql->bindParam(5, $this->fechaNacimiento, PDO::PARAM_STR);
            # Correo Electronico
            $sql->bindParam(6, $this->email, PDO::PARAM_STR);
            # Genero
            $sql->bindParam(7, $this->genero, PDO::PARAM_STR);
            # Estado
            $sql->bindParam(8, $this->estado, PDO::PARAM_STR);
            # Telefono
            $sql->bindParam(9, $this->telefono, PDO::PARAM_STR);
            # EPS
            $sql->bindParam(10, $this->eps, PDO::PARAM_STR);
            # Tipo Sangre
            $sql->bindParam(11, $this->tipoSangre, PDO::PARAM_STR);
            # Telefono de Emergencia
            $sql->bindParam(12, $this->telefonoEmergencia, PDO::PARAM_STR);
            # Hashed 
            $passwordHashed = password_hash($this->password, PASSWORD_DEFAULT);
            # Contraseña
            $sql->bindParam(13, $passwordHashed, PDO::PARAM_STR);
            # Observaciones
            $sql->bindParam(14, $this->observaciones, PDO::PARAM_STR);
            
            # 3. Se ejecuta la consulta
            $res = $sql->execute();
            
            // Guardar el ID para poder recuperarlo después
            $this->id = $nextId;
            
            return $res;
        } catch (PDOException $ex) {
            echo "Error en la consulta> " .$ex->getMessage();
            return false;
        }
    }

    // Método para obtener el ID del último registro insertado
    public function getLastInsertId() {
        return $this->id;
    }

    // Método para obtener el siguiente ID disponible
    private function getNextId() {
        try {
            $sql = "SELECT MAX(id) as max_id FROM $this->table";
            $statement = $this->dbConnection->query($sql);
            $result = $statement->fetch(PDO::FETCH_OBJ);
            return ($result->max_id ?? 0) + 1;
        } catch (PDOException $ex) {
            echo "Error al obtener el siguiente ID> " .$ex->getMessage();
            return 1; // Si hay error, intentamos con ID 1
        }
    }

    public function getEntrenador() {
        try {
            $sql = "SELECT * FROM $this->table WHERE id=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $this->id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $ex) {
            echo "Error al obtener el Entrenador> ".$ex->getMessage();
            return [];
        }
    }

    public function editEntrenador() {
        try {
            $sql = "UPDATE $this->table SET nombre=:nombre, tipoDocumento=:tipoDocumento, documento=:documento, fechaNacimiento=:fechaNacimiento, email=:email, genero=:genero, estado=:estado, telefono=:telefono, eps=:eps, tipoSangre=:tipoSangre, telefonoEmergencia=:telefonoEmergencia, observaciones=:observaciones WHERE id=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $this->id, PDO::PARAM_INT);
            $statement->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $statement->bindParam(":tipoDocumento", $this->tipoDocumento, PDO::PARAM_STR);
            $statement->bindParam(":documento", $this->documento, PDO::PARAM_STR);
            $statement->bindParam(":fechaNacimiento", $this->fechaNacimiento, PDO::PARAM_STR);
            $statement->bindParam(":email", $this->email, PDO::PARAM_STR);
            $statement->bindParam(":genero", $this->genero, PDO::PARAM_STR);
            $statement->bindParam(":estado", $this->estado, PDO::PARAM_STR);
            $statement->bindParam(":telefono", $this->telefono, PDO::PARAM_STR);
            $statement->bindParam(":eps", $this->eps, PDO::PARAM_STR);
            $statement->bindParam(":tipoSangre", $this->tipoSangre, PDO::PARAM_STR);
            $statement->bindParam(":telefonoEmergencia", $this->telefonoEmergencia, PDO::PARAM_STR);
            $statement->bindParam(":observaciones", $this->observaciones, PDO::PARAM_STR);
            
            // Solo actualizamos la contraseña si se proporciona una nueva
            if (!empty($this->password)) {
                $passwordHashed = password_hash($this->password, PASSWORD_DEFAULT);
                $sql = "UPDATE $this->table SET password=:password WHERE id=:id";
                $pwdStatement = $this->dbConnection->prepare($sql);
                $pwdStatement->bindParam(":id", $this->id, PDO::PARAM_INT);
                $pwdStatement->bindParam(":password", $passwordHashed, PDO::PARAM_STR);
                $pwdStatement->execute();
            }
            
            $resp = $statement->execute();
            return $resp;
        } catch (PDOException $ex) {
            echo "El Entrenador no pudo ser editado> ".$ex->getMessage();
            return false;
        }
    }

    public function deleteEntrenador() {
        try {
            $sql = "DELETE FROM $this->table WHERE id=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $this->id, PDO::PARAM_INT);
            $resp = $statement->execute();
            return $resp;
        } catch (PDOException $ex) {
            echo "El entrenador no pudo ser eliminado> ".$ex->getMessage();
            return false;
        }
    }
}
?>