<?php
namespace App\Models;

require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use DateTime;
use PDO;
use PDOException;

class ControlProgresoModel extends BaseModel
{
    public function __construct(
        private ?int $id = null,
        private ?string $fechaRealizacion = null,
        private ?string $peso = null,
        private ?string $cintura = null,
        private ?string $cadera = null,
        private ?string $musloDerecho = null,
        private ?string $musloIsquierdo = null,
        private ?string $brazoDerecho = null,
        private ?string $brazoIzquierdo = null,
        private ?string $antebrazoDerecho = null,
        private ?string $antebrazoIzquierdo = null,
        private ?string $pantorrillaDerecha = null,
        private ?string $pantorrillaIzquierda = null,
        private ?string $examenMedico = null,
        private ?string $observaciones = null,
        private ?string $fechaExamen = null,
        private ?int $fkIdUsuario = null
    )
    {
        # Se llama al constructor del padre
        parent::__construct();
        # Se específica la tabla
        $this->table = "controlprogreso";
    }

    public function validarLogin($email, $password) {
        try {
            $sql = "SELECT * FROM usuario WHERE email=:email";
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

    # Método para obtener el ID del último registro insertado 
    public function getLastInsertId()
    {
        return $this->id;
    }

    # Método para obtener el siguiente ID disponible
    private function getNextId()
    {
        try {
            $sql = "SELECT MAX(id) as max_id FROM $this->table";
            $statement = $this->dbConnection->query($sql);
            $result = $statement->fetch(PDO::FETCH_OBJ);
            return ($result->max_id ?? 0) + 1;
        } catch (PDOException $ex) {
            echo "Error al obtener el siguiente ID> " . $ex->getMessage();
            return 1; # Si hay error intenteamos con el ID 1
        }
    }

    public function save()
    {
        try {
            # Verificar si hay un ID disponible
            $nextId = $this->getNextId();

            # Se prepara la consulta
            $sql = $this->dbConnection->prepare("INSERT INTO $this->table (id, fechaRealizacion, peso, cintura, cadera, musloDerecho, musloIsquierdo, brazoDerecho, brazoIzquierdo, antebrazoDerecho, antebrazoIzquierdo, pantorrillaDerecha, pantorrillaIzquierda, examenMedico, observaciones, fechaExamen, fkIdUsuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            # Se reemplazan los datos con bindParam
            $sql->bindParam(1, $nextId, PDO::PARAM_INT);
            $sql->bindParam(2, $this->fechaRealizacion, PDO::PARAM_STR);
            $sql->bindParam(3, $this->peso, PDO::PARAM_STR);
            $sql->bindParam(4, $this->cintura, PDO::PARAM_STR);
            $sql->bindParam(5, $this->cadera, PDO::PARAM_STR);
            $sql->bindParam(6, $this->musloDerecho, PDO::PARAM_STR);
            $sql->bindParam(7, $this->musloIsquierdo, PDO::PARAM_STR);
            $sql->bindParam(8, $this->brazoDerecho, PDO::PARAM_STR);
            $sql->bindParam(9, $this->brazoIzquierdo, PDO::PARAM_STR);
            $sql->bindParam(10, $this->antebrazoDerecho, PDO::PARAM_STR);
            $sql->bindParam(11, $this->antebrazoIzquierdo, PDO::PARAM_STR);
            $sql->bindParam(12, $this->pantorrillaDerecha, PDO::PARAM_STR);
            $sql->bindParam(13, $this->pantorrillaIzquierda, PDO::PARAM_STR);
            $sql->bindParam(14, $this->examenMedico, PDO::PARAM_STR);
            $sql->bindParam(15, $this->observaciones, PDO::PARAM_STR);
            $sql->bindParam(16, $this->fechaExamen, PDO::PARAM_STR);
            $sql->bindParam(17, $this->fkIdUsuario, PDO::PARAM_INT);
            # Se ejecuta la consulta
            $response = $sql->execute();
            # Guardar el ID para poder recuperarlo después
            $this->id = $nextId;
            return $response;
        } catch (PDOException $ex) {
            echo "Error en la consulta> ". $ex->getMessage();
            return false;
        }
    }

    public function getControlProgreso()
    {
        try {
            $sql = $this->dbConnection->prepare("SELECT * FROM $this->table WHERE id=:id");
            $sql->bindParam(":id", $this->id, PDO::PARAM_INT);
            $sql->execute();
            $response = $sql->fetchAll(PDO::FETCH_OBJ);
            return $response;
        } catch (PDOException $ex) {
            echo "Error al obtener el Control de Progreso> ". $ex->getMessage();
            return [];
        }
    }

    public function editControlProgreso()
    {
        try {
            $sql = $this->dbConnection->prepare("UPDATE $this->table SET fechaRealizacion=:fechaRealizacion, peso=:peso, cintura=:cintura, cadera=:cadera, musloDerecho=:musloDerecho, musloIsquierdo=:musloIsquierdo, brazoDerecho=:brazoDerecho, brazoIzquierdo=:brazoIzquierdo, antebrazoDerecho=:antebrazoDerecho, antebrazoIzquierdo=:antebrazoIzquierdo, pantorrillaDerecha=:pantorrillaDerecha, pantorrillaIzquierda=:pantorrillaIzquierda, examenMedico=:examenMedico, observaciones=:observaciones, fechaExamen=:fechaExamen, fkIdUsuario=:fkIdUsuario WHERE id=:id");
            $sql->bindParam(":id", $this->id, PDO::PARAM_INT);
            $sql->bindParam(":fechaRealizacion", $this->fechaRealizacion, PDO::PARAM_STR);
            $sql->bindParam(":peso", $this->peso, PDO::PARAM_STR);
            $sql->bindParam(":cintura", $this->cintura, PDO::PARAM_STR);
            $sql->bindParam(":cadera", $this->cadera, PDO::PARAM_STR);
            $sql->bindParam(":musloDerecho", $this->musloDerecho, PDO::PARAM_STR);
            $sql->bindParam(":musloIsquierdo", $this->musloIsquierdo, PDO::PARAM_STR);
            $sql->bindParam(":brazoDerecho", $this->brazoDerecho, PDO::PARAM_STR);
            $sql->bindParam(":brazoIzquierdo", $this->brazoIzquierdo, PDO::PARAM_STR);
            $sql->bindParam(":antebrazoDerecho", $this->antebrazoDerecho, PDO::PARAM_STR);
            $sql->bindParam(":antebrazoIzquierdo", $this->antebrazoIzquierdo, PDO::PARAM_STR);
            $sql->bindParam(":pantorrillaDerecha", $this->pantorrillaDerecha, PDO::PARAM_STR);
            $sql->bindParam(":pantorrillaIzquierda", $this->pantorrillaIzquierda, PDO::PARAM_STR);
            $sql->bindParam(":examenMedico", $this->examenMedico, PDO::PARAM_STR);
            $sql->bindParam(":observaciones", $this->observaciones, PDO::PARAM_STR);
            $sql->bindParam(":fechaExamen", $this->fechaExamen, PDO::PARAM_STR);
            $sql->bindParam(":fkIdUsuario", $this->fkIdUsuario, PDO::PARAM_INT);
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "El control de progreso no pudo ser editado> ". $ex->getMessage();
            return false;
        }
    }

    public function deleteControlProgreso()
    {
        try {
            $sql = $this->dbConnection->prepare("DELETE FROM $this->table WHERE id=:id");
            $sql->bindParam(":id", $this->id, PDO::PARAM_INT);
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "El control de progreso no pudo ser eliminado> ". $ex->getMessage();
            return false;
        }
    }

    # Método para obtener solo los aprendices (rol 3)
    public function getAprendicesOnly()
    {
        try {
            $sql = "SELECT * FROM usuario WHERE fkIdRol = 3";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener los aprendices> ". $ex->getMessage();
            return [];
        }
    }
}

?>