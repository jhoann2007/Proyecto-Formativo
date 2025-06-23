<?php
namespace App\Models;
require_once MAIN_APP_ROUTE . "../models/baseModel.php";

class CalendarioModel extends BaseModel
{
    public function __construct(
        private ?int $id_calendario = null,
        private ?string $fecha = null,
        private ?string $hora_inicio = null,
        private ?string $hora_cierre = null,
        private ?int $id_encargado = null,
        private ?int $capacidad_max = null,
        private ?string $estado = 'activo'
    ) {
        parent::__construct();
        $this->table = "calendario";
    }

    public function save()
    {
        $sql = "INSERT INTO $this->table (fecha, hora_inicio, hora_cierre, id_encargado, capacidad_max, estado)
                VALUES (:fecha, :hora_inicio, :hora_cierre, :id_encargado, :capacidad_max, :estado)";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':hora_cierre', $this->hora_cierre);
        $stmt->bindParam(':id_encargado', $this->id_encargado);
        $stmt->bindParam(':capacidad_max', $this->capacidad_max);
        $stmt->bindParam(':estado', $this->estado);
        return $stmt->execute();
    }

    public function update()
    {
        $sql = "UPDATE $this->table SET 
                fecha = :fecha, 
                hora_inicio = :hora_inicio, 
                hora_cierre = :hora_cierre, 
                id_encargado = :id_encargado, 
                capacidad_max = :capacidad_max, 
                estado = :estado,
                updated_at = CURRENT_TIMESTAMP
                WHERE id_calendario = :id_calendario";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_calendario', $this->id_calendario);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':hora_cierre', $this->hora_cierre);
        $stmt->bindParam(':id_encargado', $this->id_encargado);
        $stmt->bindParam(':capacidad_max', $this->capacidad_max);
        $stmt->bindParam(':estado', $this->estado);
        return $stmt->execute();
    }

    public function getEventosCalendario()
    {
        $sql = "SELECT c.*, e.nombre as nombre_entrenador 
                FROM $this->table c 
                INNER JOIN entrenadores e ON c.id_encargado = e.id 
                ORDER BY c.fecha ASC";
        return $this->dbConnection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByDate($fecha)
    {
        $sql = "SELECT c.*, e.nombre as nombre_entrenador 
                FROM $this->table c 
                INNER JOIN entrenadores e ON c.id_encargado = e.id 
                WHERE c.fecha = :fecha";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getEntrenadores()
    {
        $sql = "SELECT id, nombre FROM entrenadores WHERE estado = 'activo' ORDER BY nombre ASC";
        return $this->dbConnection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM $this->table WHERE id_calendario = :id";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}