<?php
namespace App\Models;

require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use PDO;
use PDOException;

class AgregarProgramaModel extends BaseModel
{
    public function __construct(
        private ?int $id_trainingprogram = null,
        private ?string $token_number = null,
        private ?string $name = null,
        private ?int $id_trainingcenter = null
    )
    {
        # Se llama al constructor del padre
        parent::__construct();
        # Se específica la tabla
        $this->table = "trainingprogram";
    }

    public function save()
    {
        try {
            # 1. Se prepara la consulta 
            $sql = $this->dbConnection->prepare("INSERT INTO $this->table (id_trainingprogram, token_number, name, id_trainingcenter) VALUES (?, ?, ?, ?)");
            # 2. Se reemplazan los valores con bindParam
            $sql->bindParam(1, $this->id_trainingprogram, PDO::PARAM_INT);
            $sql->bindParam(2, $this->token_number, PDO::PARAM_STR);
            $sql->bindParam(3, $this->name, PDO::PARAM_STR);
            $sql->bindParam(4, $this->id_trainingcenter, PDO::PARAM_INT);
            # 3. Se ejecuta la consulta
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "Error en la consulta> " . $ex->getMessage();
            return false;
        }
    }

    public function getAllPrograms()
    {
        try {
            #1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("SELECT * FROM $this->table");
            # Se ejecuta la consulta
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener todos los programas> " . $ex->getMessage();
            return [];
        }
    }

    public function editProgram()
    {
        try {
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("UPDATE $this->table SET token_number=:token_number, name=:name, id_trainingcenter=:id_trainingcenter WHERE id_trainingprogram=:id_trainingprogram");
            # 2. Se reemplazan las consultas con bindParam
            $sql->bindParam(':id_trainingprogram', $this->id_trainingprogram, PDO::PARAM_INT );
            $sql->bindParam(':token_number', $this->token_number, PDO::PARAM_STR );
            $sql->bindParam(':name', $this->name, PDO::PARAM_STR );
            $sql->bindParam(':id_trainingcenter', $this->id_trainingcenter, PDO::PARAM_INT );
            # 3. Se ejecuta la consulta
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "Error al editar el programa> ". $ex->getMessage();
            return false;
        }
    }

    public function deleteProgram()
    {
        try {
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("DELETE FROM $this->table WHERE id_trainingprogram=:id_trainingprogram");
            # 2. Se reemplazan los valores con bindParam
            $sql->bindParam(":id_trainingprogram", $this->id_trainingprogram, PDO::PARAM_INT);
            # 3. Se ejecuta la consulta
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "Error al eliminar el programa> " . $ex->getMessage();
            return false;
        }
    }

    public function getCenters()
    {
        try {
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("SELECT * FROM trainingcenter");
            # 2. Se ejecuta la consulta
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al traer los centros de formacion> " . $ex->getMessage();
            return [];
        }
    }
}
?>