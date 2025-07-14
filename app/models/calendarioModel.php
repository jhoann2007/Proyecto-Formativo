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

    public function updateEvento($id, $fecha, $hora_inicio, $hora_cierre, $id_encargado, $capacidad_max, $estado)
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
        $stmt->bindParam(':id_calendario', $id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora_inicio', $hora_inicio);
        $stmt->bindParam(':hora_cierre', $hora_cierre);
        $stmt->bindParam(':id_encargado', $id_encargado);
        $stmt->bindParam(':capacidad_max', $capacidad_max);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function getEventosCalendario()
    {
        $sql = "SELECT c.*, u.nombre as nombre_entrenador 
                FROM $this->table c
                INNER JOIN usuario u ON c.id_encargado = u.id
                WHERE u.fkIdRol = 2 AND u.estado = 'activo'
                ORDER BY c.fecha ASC";
        return $this->dbConnection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByDate($fecha)
    {
        $sql = "SELECT c.*, u.nombre as nombre_entrenador
                FROM $this->table c
                INNER JOIN usuario u ON c.id_encargado = u.id
                WHERE c.fecha = :fecha AND u.fkIdRol = 2";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getEntrenadores()
    {
        $sql = "SELECT id, nombre FROM usuario WHERE estado = 'activo' AND fkIdRol = 2 ORDER BY nombre ASC";
        return $this->dbConnection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteById($id)
    {
        // Primero eliminar registros de aprendices relacionados
        $sqlAprendices = "DELETE FROM aprendiz_registros WHERE id_calendario = :id";
        $stmtAprendices = $this->dbConnection->prepare($sqlAprendices);
        $stmtAprendices->bindParam(':id', $id);
        $stmtAprendices->execute();
                
        // Luego eliminar el evento
        $sql = "DELETE FROM $this->table WHERE id_calendario = :id";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Nuevos métodos para aprendices
    public function registrarAprendiz($idAprendiz, $idCalendario, $horaEntrada, $horaSalida, $fecha)
    {
        $sql = "INSERT INTO aprendiz_registros (id_aprendiz, id_calendario, hora_entrada, hora_salida, fecha_registro)
                VALUES (:id_aprendiz, :id_calendario, :hora_entrada, :hora_salida, :fecha_registro)";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_aprendiz', $idAprendiz);
        $stmt->bindParam(':id_calendario', $idCalendario);
        $stmt->bindParam(':hora_entrada', $horaEntrada);
        $stmt->bindParam(':hora_salida', $horaSalida);
        $stmt->bindParam(':fecha_registro', $fecha);
        return $stmt->execute();
    }

    public function verificarRegistroAprendizDia($idAprendiz, $fecha)
    {
        $sql = "SELECT COUNT(*) as total FROM aprendiz_registros
                WHERE id_aprendiz = :id_aprendiz AND fecha_registro = :fecha";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_aprendiz', $idAprendiz);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

    public function getRegistrosAprendicesPorEvento($idCalendario)
    {
        $sql = "SELECT ar.*, u.nombre as nombre_aprendiz
                FROM aprendiz_registros ar
                INNER JOIN usuario u ON ar.id_aprendiz = u.id
                WHERE ar.id_calendario = :id_calendario
                ORDER BY ar.hora_entrada ASC";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_calendario', $idCalendario);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRegistroAprendizPorFecha($idAprendiz, $fecha)
    {
        $sql = "SELECT ar.*, c.hora_inicio, c.hora_cierre
                FROM aprendiz_registros ar
                INNER JOIN calendario c ON ar.id_calendario = c.id_calendario
                WHERE ar.id_aprendiz = :id_aprendiz AND ar.fecha_registro = :fecha";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_aprendiz', $idAprendiz);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}