<?php
namespace App\Models;
require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use PDO;
use PDOException;

class EjercicioModel extends BaseModel
{
    private $id_exercise;
    private $name;
    private $example;
    private $id_musclegroup;

    public function __construct($id_exercise = null, $name = null, $example = null, $id_musclegroup = null)
    {
        parent::__construct();
        $this->table = "exercise";
        $this->id_exercise = $id_exercise;
        $this->name = $name;
        $this->example = $example;
        $this->id_musclegroup = $id_musclegroup;
    }

    public function createEjercicio()
    {
        try {
            $sql = "INSERT INTO exercise (name, example, id_musclegroup) VALUES (?, ?, ?)";
            $stmt = $this->dbConnection->prepare($sql);
            $result = $stmt->execute([$this->name, $this->example, $this->id_musclegroup]);
            return $result;
        } catch (PDOException $ex) {
            echo "Error al crear ejercicio: " . $ex->getMessage();
            return false;
        }
    }

    public function createGrupoMuscular($name, $image)
    {
        try {
            $sql = "INSERT INTO musclegroup (name, image) VALUES (?, ?)";
            $stmt = $this->dbConnection->prepare($sql);
            $result = $stmt->execute([$name, $image]);
            return $result;
        } catch (PDOException $ex) {
            echo "Error al crear grupo muscular: " . $ex->getMessage();
            return false;
        }
    }

    public function getGruposMusculares()
    {
        try {
            $sql = "SELECT * FROM musclegroup";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener grupos musculares: " . $ex->getMessage();
            return [];
        }
    }

    public function getEjercicio()
    {
        try {
            $sql = "SELECT * FROM exercise WHERE id_exercise = ?";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([$this->id_exercise]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener ejercicio: " . $ex->getMessage();
            return [];
        }
    }
}
?>