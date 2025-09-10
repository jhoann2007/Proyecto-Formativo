<?php
namespace App\Models;

require_once MAIN_APP_ROUTE . "../models/baseModel.php";

class CalendarioModel extends BaseModel
{
    public function __construct(
        private ?int $id_calendar = null,
        private ?string $date = null,
        private ?string $start_time = null,
        private ?string $end_time = null,
        private ?int $id_user = null,
        private ?int $max_capacity = null,
        private ?string $status = 'activo'
    ) {
        parent::__construct();
        $this->table = "calendar";
    }

    public function save()
    {
        $sql = "INSERT INTO $this->table (date, start_time, end_time, id_user, max_capacity, status)
                VALUES (:date, :start_time, :end_time, :id_user, :max_capacity, :status)";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':end_time', $this->end_time);
        $stmt->bindParam(':id_user', $this->id_user);
        $stmt->bindParam(':max_capacity', $this->max_capacity);
        $stmt->bindParam(':status', $this->status);
        return $stmt->execute();
    }

    public function updateEvento($id_calendar, $date, $start_time, $end_time, $id_user, $max_capacity, $status): bool
    {
        $sql = "UPDATE $this->table SET 
                date = :date,
                start_time = :start_time,
                end_time = :end_time,
                id_user = :id_user,
                max_capacity = :max_capacity,
                status = :status,
                updated_at = CURRENT_TIMESTAMP
                WHERE id_calendar = :id_calendar";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
        $stmt->bindParam(':max_capacity', $max_capacity, \PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function getEventosCalendario()
    {
        $sql = "SELECT c.id_calendar, c.date as fecha, c.start_time as hora_inicio, 
                       c.end_time as hora_cierre, c.id_user, c.max_capacity as capacidad_max, 
                       c.status as estado, u.name as nombre_entrenador
                FROM $this->table c
                INNER JOIN user u ON c.id_user = u.id_user
                WHERE u.id_role = 2 AND u.status = 'activo' AND c.status = 'activo'
                ORDER BY c.date ASC, c.start_time ASC";
        return $this->dbConnection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByDate($date): mixed
    {
        $sql = "SELECT c.id_calendar, c.date as fecha, c.start_time as hora_inicio, 
                       c.end_time as hora_cierre, c.id_user, c.max_capacity as capacidad_max, 
                       c.status as estado, u.name as nombre_entrenador
                FROM $this->table c
                INNER JOIN user u ON c.id_user = u.id_user
                WHERE c.date = :date AND u.id_role = 2";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getEntrenadores()
    {
        $sql = "SELECT id_user, name FROM user WHERE status = 'activo' AND id_role = 2 ORDER BY name ASC";
        return $this->dbConnection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteById($id_calendar)
    {
        // Eliminar aprendices relacionados primero (si existen)
        $sqlAprendices = "DELETE FROM apprenticereserves WHERE id_calendar = :id_calendar";
        $stmtAprendices = $this->dbConnection->prepare($sqlAprendices);
        $stmtAprendices->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
        $stmtAprendices->execute();
        
        // Luego eliminar el evento
        $sql = "DELETE FROM $this->table WHERE id_calendar = :id_calendar";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Verifica si el usuario existe y está activo
    public function verificarUsuarioExiste($id_user): bool
    {
        $sql = "SELECT COUNT(*) as count FROM user WHERE id_user = :id_user AND status = 'activo'";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result && ((int)$result['count'] > 0);
    }

    // Verifica si el calendario existe y está activo
    public function verificarCalendarioExiste($id_calendar): bool
    {
        $sql = "SELECT COUNT(*) as count FROM calendar WHERE id_calendar = :id_calendar AND status = 'activo'";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result && ((int)$result['count'] > 0);
    }

    // Verifica capacidad usando SELECT FOR UPDATE dentro de transacción (recomendado usar con registrarAprendiz transaccional)
    public function verificarCapacidadDisponible($id_calendar): bool
    {
        $sql = "SELECT max_capacity FROM calendar WHERE id_calendar = :id_calendar";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        $capacidad = isset($row['max_capacity']) ? (int)$row['max_capacity'] : 0;

        $sql2 = "SELECT COUNT(*) as total FROM apprenticereserves WHERE id_calendar = :id_calendar";
        $stmt2 = $this->dbConnection->prepare($sql2);
        $stmt2->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
        $stmt2->execute();
        $ocupados = (int)($stmt2->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0);

        return $ocupados < $capacidad;
    }

    /**
     * Registra un aprendiz de forma transaccional:
     * - Bloquea la fila del calendario (SELECT ... FOR UPDATE)
     * - Verifica capacidad y duplicados
     * - Inserta el registro y confirma
     */
    public function registrarAprendiz($id_user, $id_calendar, $entry_time, $departure_time, $reservation_date)
    {
        try {
            // Iniciar transacción
            $this->dbConnection->beginTransaction();

            // Bloquear fila del calendario para calcular capacidad (evita sobreventa de cupos)
            $sqlCap = "SELECT max_capacity FROM calendar WHERE id_calendar = :id_calendar FOR UPDATE";
            $stmtCap = $this->dbConnection->prepare($sqlCap);
            $stmtCap->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
            $stmtCap->execute();
            $capRow = $stmtCap->fetch(\PDO::FETCH_ASSOC);

            if (!$capRow) {
                // Calendario no existe
                $this->dbConnection->rollBack();
                return false;
            }

            $max_capacity = (int)$capRow['max_capacity'];

            // Contar cupos ocupados actualmente
            $sqlCount = "SELECT COUNT(*) as total FROM apprenticereserves WHERE id_calendar = :id_calendar";
            $stmtCount = $this->dbConnection->prepare($sqlCount);
            $stmtCount->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
            $stmtCount->execute();
            $ocupados = (int)($stmtCount->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0);

            if ($ocupados >= $max_capacity) {
                // No hay cupos
                $this->dbConnection->rollBack();
                return false;
            }

            // Verificar duplicado del mismo día para el aprendiz
            $sqlDup = "SELECT COUNT(*) as total FROM apprenticereserves WHERE id_user = :id_user AND reservation_date = :reservation_date";
            $stmtDup = $this->dbConnection->prepare($sqlDup);
            $stmtDup->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
            $stmtDup->bindParam(':reservation_date', $reservation_date);
            $stmtDup->execute();
            $dup = (int)($stmtDup->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0);

            if ($dup > 0) {
                $this->dbConnection->rollBack();
                return false;
            }

            // Insertar reserva
            $sql = "INSERT INTO apprenticereserves (id_user, id_calendar, entry_time, departure_time, reservation_date)
                    VALUES (:id_user, :id_calendar, :entry_time, :departure_time, :reservation_date)";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
            $stmt->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
            $stmt->bindParam(':entry_time', $entry_time);
            $stmt->bindParam(':departure_time', $departure_time);
            $stmt->bindParam(':reservation_date', $reservation_date);

            $ok = $stmt->execute();

            if ($ok) {
                $this->dbConnection->commit();
                return true;
            } else {
                $this->dbConnection->rollBack();
                return false;
            }
        } catch (\PDOException $e) {
            // Si sucede un error, hacer rollback y registrar en log
            if ($this->dbConnection->inTransaction()) {
                $this->dbConnection->rollBack();
            }
            error_log("Error al registrar aprendiz (modelo): " . $e->getMessage());
            return false;
        }
    }

    public function verificarRegistroAprendizDia($id_user, $reservation_date)
    {
        $sql = "SELECT COUNT(*) as total FROM apprenticereserves
                WHERE id_user = :id_user AND reservation_date = :reservation_date";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
        $stmt->bindParam(':reservation_date', $reservation_date);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ((int)$result['total'] ?? 0) > 0;
    }

    public function getRegistrosAprendicesPorEvento($id_calendar)
    {
        $sql = "SELECT ar.*, u.name as nombre_aprendiz
                FROM apprenticereserves ar
                INNER JOIN user u ON ar.id_user = u.id_user
                WHERE ar.id_calendar = :id_calendar
                ORDER BY ar.entry_time ASC";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_calendar', $id_calendar, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRegistroAprendizPorFecha($id_user, $reservation_date): mixed
    {
        $sql = "SELECT ar.*, c.start_time, c.end_time
                FROM apprenticereserves ar
                INNER JOIN calendar c ON ar.id_calendar = c.id_calendar
                WHERE ar.id_user = :id_user AND ar.reservation_date = :reservation_date";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, \PDO::PARAM_INT);
        $stmt->bindParam(':reservation_date', $reservation_date);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
