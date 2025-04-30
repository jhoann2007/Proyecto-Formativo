<?php

namespace App\Models;

// Asegúrate que la ruta a BaseModel sea correcta
require_once __DIR__ . '/BaseModel.php'; // Usar __DIR__ es más robusto

use PDO;
use PDOException;

class UserModel extends BaseModel
{
    // Constructor simple: solo inicializa el padre y define la tabla
    public function __construct()
    {
        parent::__construct(); // Llama al constructor de BaseModel (establece $this->dbConnection con PDO)
        $this->table = "usuario"; // Define la tabla para este modelo
    }

    /**
     * Busca un usuario por su email usando la conexión PDO heredada.
     *
     * @param string $email El email del usuario.
     * @return array|false Un array asociativo con los datos del usuario o false si no se encuentra.
     */
    public function findUserByEmail(string $email): array|false
    {
        try {
            // Consulta SQL usando JOIN para obtener el rol
            $sql = "SELECT u.id, u.nombre, u.password, u.fkIdRol, r.nombre as nombreRol
                    FROM {$this->table} u
                    LEFT JOIN rol r ON u.fkIdRol = r.id
                    WHERE u.email = :email"; // Placeholder para PDO

            $stmt = $this->dbConnection->prepare($sql); // Usa la conexión PDO de BaseModel

            // Vincula el parámetro usando bindParam o pasando un array a execute
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            $stmt->execute();

            // Fetch como array asociativo. fetch() es adecuado para 0 o 1 resultado.
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user; // Retorna el array del usuario o false si no se encontró

        } catch (PDOException $ex) {
            // Loguea el error para depuración (¡no mostrar en producción!)
            error_log("Error en UserModel::findUserByEmail para {$email}: " . $ex->getMessage());
            // Puedes lanzar una excepción o retornar false/null según prefieras manejar errores
            // throw new \Exception("Error al buscar el usuario.");
            return false; // Simple retorno de error
        }
    }

    // Aquí podrías añadir otros métodos relacionados con usuarios (save, update, delete, etc.)
    // similar al ejemplo de AgregarAprendizModel si los necesitas.
}