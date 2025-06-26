<?php
namespace App\Models;
require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use PDO;
use PDOException;

class RutinaModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "rutina";
    }

    public function createRutina($nombre, $calentamiento) {
        $sql = "INSERT INTO rutina (nombre, calentamiento) VALUES (?, ?)";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([$nombre, $calentamiento]);
        return $this->dbConnection->lastInsertId(); // <-- Esto retorna el ID de la rutina creada
    }

    public function getRutinas() {
        try {
            $sql = "SELECT * FROM rutina";
            $statement = $this->dbConnection->query($sql);
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo "Error al obtener rutinas: ".$ex->getMessage();
            return [];
        }
    }

    public function getEjerciciosRutina($rutinaId) {
        try {
            $sql = "SELECT e.*, er.series, er.repeticones as repeticiones, er.peso
                    FROM ejerutina er
                    JOIN ejercicios e ON er.fkIdEjercicios = e.id
                    WHERE er.fkIdRutina = :rutinaId";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':rutinaId', $rutinaId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            echo 'Error al obtener ejercicios de la rutina: ' . $ex->getMessage();
            return [];
        }
    }

    public function getAllEjercicios() {
        $sql = "SELECT * FROM ejercicios";
        return $this->dbConnection->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public function agregarEjercicioARutina($rutinaId, $ejercicioId, $series, $repeticiones, $peso) {
        $sql = "INSERT INTO ejerutina (series, repeticones, peso, fkIdEjercicios, fkIdRutina)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([$series, $repeticiones, $peso, $ejercicioId, $rutinaId]);
    }
}
?>