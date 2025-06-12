<?php
/* ------------------------------ */
/* 2. MODELO: calendarioModel.php */
/* ------------------------------ */

namespace App\Models;
require_once MAIN_APP_ROUTE . "../models/baseModel.php";

class CalendarioModel extends BaseModel
{
    public function __construct(
        private ?int $id = null,
        private ?string $nombre = null,
        private ?string $horasDisponibles = null,
        private ?string $entrenadoresAsignados = null,
        private ?string $eventos = null,
        private ?string $fechaCreacion = null
    ) {
        parent::__construct();
        $this->table = "horario";
    }

    public function save()
    {
        $sql = "INSERT INTO $this->table (nombre, horasDisponibles, entrenadoresAsignados, eventos, fechaCreacion)
                VALUES (:nombre, :horasDisponibles, :entrenadoresAsignados, :eventos, :fechaCreacion)";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':horasDisponibles', $this->horasDisponibles);
        $stmt->bindParam(':entrenadoresAsignados', $this->entrenadoresAsignados);
        $stmt->bindParam(':eventos', $this->eventos);
        $stmt->bindParam(':fechaCreacion', $this->fechaCreacion);
        return $stmt->execute();
    }

    public function getHorarios()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->dbConnection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByDate($date)
    {
        $sql = "SELECT * FROM $this->table WHERE fechaCreacion = :fecha";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':fecha', $date);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}