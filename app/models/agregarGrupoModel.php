<?php

namespace App\Models;

require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use DateTime;
use PDO;
use PDOException;

class AgregarGrupoModel extends BaseModel
{
    public function __construct(
        private ?int $id_group = null,
        private ?string $token_number = null,
        private ?string $number_aprenttices = null,
        private ?string $status = null,
        private ?string $star_date = null,
        private ?string $end_date = null,
        private ?int $id_trainingprogram = null
    ) {
        # Se llama al constructor del padre
        parent::__construct();
        # Se específica la tabla
        $this->table = "`group`";
    }

    # Método para obtener el ID del último registro insertado
    // public function getLastInsertId()
    // {
    //     return $this->id_group;
    // }

    // # Método para obtener el siguiente ID disponible
    // private function getNextId()
    // {
    //     try {
    //         $sql = "SELECT MAX(id_group) as max_id FROM $this->table";
    //         $statement = $this->dbConnection->query($sql);
    //         $result = $statement->fetch(PDO::FETCH_OBJ);
    //         return ($result->max_id == 0) + 1;
    //     } catch (PDOException $ex) {
    //         echo "Error al obtener el siguiente ID> " . $ex->getMessage();
    //         return 1; # Si hay error, intententamos con ID 1
    //     }
    // }

    public function save()
    {
        try {
            # Verificar si hay un ID disponible
            // $nextId = $this->getNextId();
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("INSERT INTO $this->table (id_group, token_number, number_aprenttices, status, star_date, end_date, id_trainingprogram) VALUES (?, ?, ?, ?, ?, ?, ?)");
            # 2. Se reemplazan las variables con bindParam
            $sql->bindParam(1, $this->id_group, PDO::PARAM_INT);
            $sql->bindParam(2, $this->token_number, PDO::PARAM_STR);
            $sql->bindParam(3, $this->number_aprenttices, PDO::PARAM_STR);
            $sql->bindParam(4, $this->status, PDO::PARAM_STR);
            $sql->bindParam(5, $this->star_date, PDO::PARAM_STR);
            $sql->bindParam(6, $this->end_date, PDO::PARAM_STR);
            $sql->bindParam(7, $this->id_trainingprogram, PDO::PARAM_INT);
            # 3. Se ejecuta la consulta
            $response = $sql->execute();
            # Guardar el ID para poder recuperarlo después
            // $this->id_group = $nextId;
            return $response;
        } catch (PDOException $ex) {
            echo "Error en la consulta> " . $ex->getMessage();
            return false;
        }
    }

    public function getAllGroups()
    {
        try {
            $sql = $this->dbConnection->prepare("SELECT * FROM $this->table");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener todos los Grupos> " . $ex->getMessage();
            return [];
        }
    }

    // public function getGroup()
    // {
    //     try {
    //         # 1. Se prepara la consulta
    //         $sql = $this->dbConnection->prepare("SELECT * FROM $this->table WHERE id_group=:id_group");
    //         # 2. Se reemplazan las variables con bindParam
    //         $sql->bindParam(":id_group", $this->id_group, PDO::PARAM_INT);
    //         # 3. Se ejecuta la consulta
    //         $sql->execute();
    //         $response = $sql->fetchAll(PDO::FETCH_OBJ);
    //         return $response;
    //     } catch (PDOException $ex) {
    //         echo "Error al obtener los Grupos> " . $ex->getMessage();
    //         return [];
    //     }
    // }

    public function editGroup()
    {
        try {
            #1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("UPDATE $this->table SET token_number=:token_number, number_aprenttices=:number_aprenttices, status=:status, star_date=:star_date, end_date=:end_date, id_trainingprogram=:id_trainingprogram WHERE id_group=:id_group");
            # 2. Se reemplazan los valores con bindParam
            $sql->bindParam(":id_group", $this->id_group, PDO::PARAM_INT);
            $sql->bindParam(":token_number", $this->token_number, PDO::PARAM_STR);
            $sql->bindParam(":number_aprenttices", $this->number_aprenttices, PDO::PARAM_STR);
            $sql->bindParam(":status", $this->status, PDO::PARAM_STR);
            $sql->bindParam(":star_date", $this->star_date, PDO::PARAM_STR);
            $sql->bindParam(":end_date", $this->end_date, PDO::PARAM_STR);
            $sql->bindParam(":id_trainingprogram", $this->id_trainingprogram, PDO::PARAM_INT);
            # 3. Se ejecuta la consulta 
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "El Grupo no pudo ser editado> " . $ex->getMessage();
            return false;
        }
    }

    public function deleteGroup()
    {
        try {
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("DELETE FROM $this->table WHERE id_group=:id_group");
            # 2. Se reemplazan los varoles con bindParam
            $sql->bindParam(":id_group", $this->id_group, PDO::PARAM_INT);
            # 3. Se ejecuta la consulta
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "El Grupo no pudo ser eliminado> " . $ex->getMessage();
            return false;
        }
    }

    public function getProgramasFormacion()
    {
        try {
            $sql = "SELECT * FROM trainingprogram";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener centros de formación> " . $ex->getMessage();
            return [];
        }
    }
}
