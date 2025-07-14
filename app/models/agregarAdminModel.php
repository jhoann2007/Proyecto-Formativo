<?php

namespace App\Models;

require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use DateTime;
use PDO;
use PDOException;

class AgregarAdminModel extends BaseModel
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
        private ?string $telefonoEmerjencia = null,
        private ?string $password = null,
        private ?string $observaciones = null,
        private ?int $fkIdRol = null
    ) {
        # Se llama al constructor del padre
        parent::__construct();
        # Se específica la tabla 
        $this->table = "usuario"; 
    }

    public function validarLogin($email, $password) {
        try {
            $sql = "SELECT * FROM usuario WHERE email=:email";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->execute();
            $resultSet = [];
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $resultSet[] = $row;
            }
            # Si se encuentra el usuario
            if (count($resultSet) > 0) {
                # Recuperamos de la Base de Datos la contraseña encriptada
                $hashed = $resultSet[0]->password;
                if (password_verify($password, $hashed)) {
                    # Los datos de usuario y contraseña son correctos
                    $_SESSION['rol'] = $resultSet[0]->fkIdRol;
                    $_SESSION['nombre'] = $resultSet[0]->nombre;
                    $_SESSION['id'] = $resultSet[0]->id;
                    $_SESSION['timeout'] = time();
                    session_regenerate_id();
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        } catch (PDOException $ex) {
            echo "Error validando login> ". $ex->getMessage();
            return false;
        }
    }

    # Método para obtener solo los Admins (rol 1)
    public function getAdminOnly() {
        try {
            $sql = "SELECT * FROM $this->table WHERE fkIdRol = 1";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener los administradores> ". $ex->getMessage();
            return [];
        }
    }

    public function save() {
        try {
            # Verificar si hay un ID disponible
            $nextId = $this->getNextId();

            # 1. Se prepara la consulta 
            $sql = $this->dbConnection->prepare("INSERT INTO $this->table (id, nombre, tipoDocumento, documento, fechaNacimiento, email, genero, estado, telefono, eps, tipoSangre, telefonoEmerjencia, password, observaciones, fkIdRol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            # 2. Se reemplazan las variables con bindParam
            # ID
            $sql->bindParam(1, $nextId, PDO::PARAM_INT);
            # Nombre
            $sql->bindParam(2, $this->nombre, PDO::PARAM_STR);
            # Tipo de Documento
            $sql->bindParam(3, $this->tipoDocumento, PDO::PARAM_STR);
            # Documento 
            $sql->bindParam(4, $this->documento, PDO::PARAM_STR);
            # Fecha de Nacimiento
            $sql->bindParam(5, $this->fechaNacimiento, PDO::PARAM_STR);
            # Correo Electronico 
            $sql->bindParam(6, $this->email, PDO::PARAM_STR);
            # Género
            $sql->bindParam(7, $this->genero, PDO::PARAM_STR);
            # Estado 
            $sql->bindParam(8, $this->estado, PDO::PARAM_STR);
            # Teléfono
            $sql->bindParam(9, $this->telefono, PDO::PARAM_STR);
            # Eps
            $sql->bindParam(10, $this->eps, PDO::PARAM_STR);
            # Tipo de Sangre
            $sql->bindParam(11, $this->tipoSangre, PDO::PARAM_STR);
            # Tepefono de Emergencia
            $sql->bindParam(12, $this->telefonoEmerjencia, PDO::PARAM_STR);
            # Hashed
            $passwordHashed = password_hash($this->password, PASSWORD_DEFAULT);
            # Contraseña
            $sql->bindParam(13, $passwordHashed, PDO::PARAM_STR);
            # Observaciones
            $sql->bindParam(14, $this->observaciones, PDO::PARAM_STR);
            # FkIdRol
            $sql->bindParam(15, $this->fkIdRol, PDO::PARAM_INT);

            # 3. Se ejecuta la consulta
            $respuesta = $sql->execute();

            # Guardar el ID para poder recuperarlo después 
            $this->id = $nextId;

            return $respuesta;
        } catch (PDOException $ex) {
            echo "Error en la consulta> ". $ex->getMessage();
            return false;
        }
    }

    # Método para obtener el ID del último registro insertado
    public function getLastInsertId() {
        return $this->id;
    }

    # Método para obtener el siguiente ID disponible 
    private function getNextId() {
        try {
            $sql = "SELECT MAX(id) as max_id FROM $this->table";
            $statement = $this->dbConnection->query($sql);
            $result = $statement->fetch(PDO::FETCH_OBJ);
            return ($result->max_id ?? 0) + 1;
        } catch (PDOException $ex) {
            echo "Error al obtener el siguiente ID> ". $ex->getMessage();
            return 1; # Si hay error, intentamos con el ID 1
        }
    }

    public function getAdmin() {
        try {
            $sql = "SELECT * FROM $this->table WHERE id=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $this->id, PDO::PARAM_INT);
            $statement->execute();
            $resultado = $statement->fetchAll(PDO::FETCH_OBJ);
            return $resultado;
        } catch (PDOException $ex) {
            echo "Error al obtener el Administrador> ". $ex->getMessage();
            return [];
        }
    }

    public function editAdmin() {
        try {
            $sql = "UPDATE $this->table SET nombre=:nombre, tipoDocumento=:tipoDocumento, documento=:documento, fechaNacimiento=:fechaNacimiento, email=:email, genero=:genero, estado=:estado, telefono=:telefono, eps=:eps, tipoSangre=:tipoSangre, telefonoEmerjencia=:telefonoEmerjencia, observaciones=:observaciones, fkIdRol=:fkIdRol WHERE id=:id";
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
            $statement->bindParam(":telefonoEmerjencia", $this->telefonoEmerjencia, PDO::PARAM_STR);
            $statement->bindParam(":observaciones", $this->observaciones, PDO::PARAM_STR);
            $statement->bindParam(":fkIdRol", $this->fkIdRol, PDO::PARAM_INT);

            # Solo actualizamos la contraseña si se proporciona una nueva
            if (!empty($this->password)) {
                $passwordHashed = password_hash($this->password, PASSWORD_DEFAULT);
                $sql = "UPDATE $this->table SET password=:password WHERE id=:id";
                $pwdStatement = $this->dbConnection->prepare($sql);
                $pwdStatement->bindParam(":id", $this->id, PDO::PARAM_INT);
                $pwdStatement->bindParam(":password", $passwordHashed, PDO::PARAM_STR);
                $pwdStatement->execute();
            }

            $respuesta = $statement->execute();
            return $respuesta;
        } catch (PDOException $ex) {
            echo "El Administrador no pudo ser editado> ". $ex->getMessage();
            return false;
        }
    }

    public function deleteAdmin() {
        try {
            $sql = "DELETE FROM $this->table WHERE id=:id";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id", $this->id, PDO::PARAM_INT);
            $respuesta = $statement->execute();
            return $respuesta;
        } catch (PDOException $ex) {
            echo "El Administrador no pudo ser eliminado> ". $ex->getMessage();
            return false;
        }
    }

    # Método para obtener roles 
    public function getRoles() {
        try {
            $sql = "SELECT * FROM rol";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener roles> ". $ex->getMessage();
            return [];
        }
    }
}

?>