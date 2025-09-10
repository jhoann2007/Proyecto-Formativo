<?php

namespace App\Models;

require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use DateTime;
use PDO;
use PDOException;

class AgregarUsuarioModel extends BaseModel
{
    public function __construct(
        private ?int $id_user = null,
        private ?string $name = null,
        private ?string $document_type = null,
        private ?string $document = null,
        private ?string $birthdate = null,
        private ?string $email = null,
        private ?string $gender = null,
        private ?string $status = null, 
        private ?string $phone = null,
        private ?string $eps = null,
        private ?string $blood_type = null,
        private ?string $weight = null, 
        private ?string $stature = null,
        private ?string $emergency_phone = null,
        private ?string $password = null,
        private ?string $observations = null,
        private ?int $id_role = null,
        private ?int $id_group = null,
        private ?int $id_trainingcenter = null
    ) {
        # Se llama al constructor del padre
        parent::__construct();
        # Se especifica la tabla 
        $this->table = "user";
    }

    public function validarLogin($email, $password) {
        try {
            $sql = "SELECT * FROM user WHERE email=:email";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->execute();
            $resultSet = [];
            while($row = $statement->fetch(PDO::FETCH_OBJ)) {
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

    # Método para obtener solo los aprendices (rol 3)
    public function getAprendicesOnly() {
        try {
            $sql = "SELECT * FROM $this->table WHERE id_role = 3";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener aprendices> ".$ex->getMessage();
            return [];
        }
    }

    # Método para obtener solo los entrenadores (rol 2)
    public function getEntrenadoresOnly() {
        try {
            $sql = "SELECT * FROM $this->table WHERE id_role = 2";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener entrenadores> ".$ex->getMessage();
            return [];
        }
    }

    # Método para obtener solo los entrenadores (rol 1)
    public function getAdminsOnly() {
        try {
            $sql = "SELECT * FROM $this->table WHERE id_role = 1";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener administradores> ".$ex->getMessage();
            return [];
        }
    }

    # Método para obtener el ID del último registro insertado
    public function getLastInsertId() {
        return $this->id_user;
    }

    # Método para obtener el siguiente ID disponible
    private function getNextId() {
        try {
            $sql = "SELECT MAX(id_user) as max_id FROM $this->table";
            $statement = $this->dbConnection->query($sql);
            $result = $statement->fetch(PDO::FETCH_OBJ);
            return ($result->max_id ?? 0) + 1;
        } catch (PDOException $ex) {
            echo "Error al obtener el siguiente ID> " .$ex->getMessage();
            return 1; // Si hay error, intentamos con ID 1
        }
    }

    public function save() {
        try {
            // Verificar si hay un ID disponible
            $nextId = $this->getNextId();
            
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("INSERT INTO $this->table (id_user, name, document_type, document, birthdate, email, gender, status, phone, eps, blood_type, weight, stature, emergency_phone, password, observations, id_role, id_group, id_trainingcenter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            # 2. Se reemplazan las variables con bindParam
            # ID
            $sql->bindParam(1, $nextId, PDO::PARAM_INT);
            # Nombre
            $sql->bindParam(2, $this->name, PDO::PARAM_STR);
            # Tipo Documento
            $sql->bindParam(3, $this->document_type, PDO::PARAM_STR);
            # Documento
            $sql->bindParam(4, $this->document, PDO::PARAM_STR);
            # Fecha Nacimiento
            $sql->bindParam(5, $this->birthdate, PDO::PARAM_STR);
            # Correo Electronico
            $sql->bindParam(6, $this->email, PDO::PARAM_STR);
            # Genero
            $sql->bindParam(7, $this->gender, PDO::PARAM_STR);
            # Estado
            $sql->bindParam(8, $this->status, PDO::PARAM_STR);
            # Telefono
            $sql->bindParam(9, $this->phone, PDO::PARAM_STR);
            # EPS
            $sql->bindParam(10, $this->eps, PDO::PARAM_STR);
            # Tipo Sangre
            $sql->bindParam(11, $this->blood_type, PDO::PARAM_STR);
            # Peso
            $sql->bindParam(12, $this->weight, PDO::PARAM_STR);
            # Estatura
            $sql->bindParam(13, $this->stature, PDO::PARAM_STR);
            # Telefono de Emergencia
            $sql->bindParam(14, $this->emergency_phone, PDO::PARAM_STR);
            # Hashed 
            $passwordHashed = password_hash($this->password, PASSWORD_DEFAULT);
            # Contraseña
            $sql->bindParam(15, $passwordHashed, PDO::PARAM_STR);
            # Observaciones
            $sql->bindParam(16, $this->observations, PDO::PARAM_STR);
            # FKidRol
            $sql->bindParam(17, $this->id_role, PDO::PARAM_INT);
            # FKidGrupo
            $sql->bindParam(18, $this->id_group, PDO::PARAM_INT);
            # FK Centro Formacion
            $sql->bindParam(19, $this->id_trainingcenter, PDO::PARAM_INT);
            
            # 3. Se ejecuta la consulta
            $res = $sql->execute();
            
            # Guardar el ID para poder recuperarlo después
            $this->id_user = $nextId;
            
            return $res;
        } catch (PDOException $ex) {
            echo "Error en la consulta> " .$ex->getMessage();
            return false;
        }
    }

    public function getUser() {
        try {
            $sql = "SELECT * FROM $this->table WHERE id_user=:id_user";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id_user", $this->id_user, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $ex) {
            echo "Error al obtener el Usuario> ".$ex->getMessage();
            return [];
        }
    }

    public function editUser() {
        try {
            $sql = "UPDATE $this->table SET name=:name, document_type=:document_type, document=:document, birthdate=:birthdate, email=:email, gender=:gender, status=:status, phone=:phone, eps=:eps, blood_type=:blood_type, weight=:weight, stature=:stature, emergency_phone=:emergency_phone, observations=:observations, id_role=:id_role, id_group=:id_group, id_trainingcenter=:id_trainingcenter WHERE id_user=:id_user";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id_user", $this->id_user, PDO::PARAM_INT);
            $statement->bindParam(":name", $this->name, PDO::PARAM_STR);
            $statement->bindParam(":document_type", $this->document_type, PDO::PARAM_STR);
            $statement->bindParam(":document", $this->document, PDO::PARAM_STR);
            $statement->bindParam(":birthdate", $this->birthdate, PDO::PARAM_STR);
            $statement->bindParam(":email", $this->email, PDO::PARAM_STR);
            $statement->bindParam(":gender", $this->gender, PDO::PARAM_STR);
            $statement->bindParam(":status", $this->status, PDO::PARAM_STR);
            $statement->bindParam(":phone", $this->phone, PDO::PARAM_STR);
            $statement->bindParam(":eps", $this->eps, PDO::PARAM_STR);
            $statement->bindParam(":blood_type", $this->blood_type, PDO::PARAM_STR);
            $statement->bindParam(":weight", $this->weight, PDO::PARAM_STR);
            $statement->bindParam(":stature", $this->stature, PDO::PARAM_STR);
            $statement->bindParam(":emergency_phone", $this->emergency_phone, PDO::PARAM_STR);
            $statement->bindParam(":observations", $this->observations, PDO::PARAM_STR);
            $statement->bindParam(":id_role", $this->id_role, PDO::PARAM_INT);
            $statement->bindParam(":id_group", $this->id_group, PDO::PARAM_INT);
            $statement->bindParam(":id_trainingcenter", $this->id_trainingcenter, PDO::PARAM_INT);
            
            // Solo actualizamos la contraseña si se proporciona una nueva
            if (!empty($this->password)) {
                $passwordHashed = password_hash($this->password, PASSWORD_DEFAULT);
                $sql = "UPDATE $this->table SET password=:password WHERE id_user=:id_user";
                $pwdStatement = $this->dbConnection->prepare($sql);
                $pwdStatement->bindParam(":id_user", $this->id_user, PDO::PARAM_INT);
                $pwdStatement->bindParam(":password", $passwordHashed, PDO::PARAM_STR);
                $pwdStatement->execute();
            }
            
            $resp = $statement->execute();
            return $resp;
        } catch (PDOException $ex) {
            echo "El Usuario no pudo ser editado> ".$ex->getMessage();
            return false;
        }
    }

    public function deleteUser() {
        try {
            $sql = "DELETE FROM $this->table WHERE id_user=:id_user";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":id_user", $this->id_user, PDO::PARAM_INT);
            $resp = $statement->execute();
            return $resp;
        } catch (PDOException $ex) {
            echo "El usuario no pudo ser eliminado> ".$ex->getMessage();
            return false;
        }
    }
    
    // Nuevos métodos para obtener roles, grupos y centros de formación
    public function getRoles() {
        try {
            $sql = "SELECT * FROM `role`";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener roles> ".$ex->getMessage();
            return [];
        }
    }
    
    public function getGrupos() {
        try {
            $sql = "SELECT * FROM `group`";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener grupos> ".$ex->getMessage();
            return [];
        }
    }
    
    public function getCentrosFormacion() {
        try {
            $sql = "SELECT * FROM trainingcenter";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener centros de formación> ".$ex->getMessage();
            return [];
        }
    }
    
    // Método para filtrar aprendices por grupo (ficha)
    public function getAprendicesByGrupo($groupId) {
        try {
            $sql = "SELECT * FROM $this->table WHERE id_group = :groupId";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(":groupId", $groupId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener aprendices por grupo> ".$ex->getMessage();
            return [];
        }
    }
}

?>