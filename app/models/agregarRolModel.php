<?php
namespace App\Models;
require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use PDO;
use PDOException;

class AgregarRolModel extends BaseModel
{
    public function __construct(
        private ?int $id_role = null,
        private ?string $name = null
    )
    {
        # Se llama al constructor padre
        parent::__construct();
        # Se específica la tabla
        $this->table = "role";
    }

    public function save()
    {
        try {
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("INSERT INTO $this->table (id_role, name) VALUES (?, ?)");
            # 2. Se reemplazan las variables con bindParam
            $sql->bindParam(1, $this->id_role, PDO::PARAM_INT);
            $sql->bindParam(2, $this->name, PDO::PARAM_STR);
            # 3. Se ejecuta la consulta
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "Error en la consulta> " . $ex->getMessage();
            return false;
        }
    }

    public function getAllRoles()
    {
        try {
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("SELECT * FROM $this->table");
            # 2. Se ejecuta la consulta en este caso
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener los Roles> ". $ex->getMessage();
            return [];
        }
    }

    public function editRole()
    {
        try {
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("UPDATE $this->table SET name=:name WHERE id_role=:id_role");
            # 2. Se reemplazan las variables con bindParam
            $sql->bindParam(":id_role", $this->id_role, PDO::PARAM_INT);
            $sql->bindParam(":name", $this->name, PDO::PARAM_STR);
            # 3. Se ejecuta la consulta 
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "Error al editar el Rol> ". $ex->getMessage();
            return false;
        }
    }

    public function deleteRole()
    {
        try {
            # 1. Se prepara la consulta
            $sql = $this->dbConnection->prepare("DELETE FROM $this->table WHERE id_role=:id_role");
            # 2. Se reemplazan las variables con bindParam
            $sql->bindParam(":id_role", $this->id_role, PDO::PARAM_INT);
            # 3. Se ejecuta la consulta
            $response = $sql->execute();
            return $response;
        } catch (PDOException $ex) {
            echo "No se puedo eliminar el Rol> ". $ex->getMessage();
            return false;
        }
    }
}
?>