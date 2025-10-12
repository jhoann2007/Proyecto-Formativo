<?php

namespace App\Models;

require_once MAIN_APP_ROUTE . "../models/baseModel.php";

use PDO;
use PDOException;

class OlvidoContraseniaModel extends BaseModel {
    private $lastError = null;
    
    public function __construct() {
        parent::__construct();
        $this->table = "user";
    }

    public function getLastError() {
        return $this->lastError;
    }
    
    /**
     * Verifica si el correo existe en la base de datos
     * @param string $email Correo a verificar
     * @return bool|object False si no existe, objeto con datos del usuario si existe
     */
    public function verificarCorreo($email) {
        try {
            $sql = "SELECT * FROM `user` WHERE email = :email";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->execute();
            
            $resultado = $statement->fetch(PDO::FETCH_OBJ);
            
            if (!$resultado) {
                $this->lastError = [
                    'type' => 'email_not_found',
                    'email' => $email
                ];
                return false;
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("ERROR: Error al verificar correo: " . $e->getMessage());
            $this->lastError = [
                'type' => 'db_exception',
                'operation' => 'verificarCorreo',
                'message' => $e->getMessage()
            ];
            return false;
        }
    }
    
    /**
     * Crea la tabla de códigos de recuperación si no existe
     */
    private function crearTablaCodigosRecuperacion() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `id_user` INT UNSIGNED NOT NULL,
                `codigo` VARCHAR(10) NOT NULL,
                `fecha_expiracion` DATETIME NOT NULL,
                `activo` TINYINT(1) NOT NULL DEFAULT 1,
                `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                KEY `idx_id_user` (`id_user`),
                CONSTRAINT `fk_prt_user` FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $this->dbConnection->exec($sql);
            // Asegurar columnas necesarias si la tabla ya existía con otro esquema
            $this->asegurarEsquemaTablaCodigos();
            return true;
        } catch (PDOException $e) {
            error_log("Error al crear tabla: " . $e->getMessage());
            $this->lastError = [
                'type' => 'db_exception',
                'operation' => 'crearTablaCodigosRecuperacion',
                'message' => $e->getMessage()
            ];
            return false;
        }
    }

    private function columnaExiste($tabla, $columna) {
        $sql = "SELECT COUNT(*) AS existe FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :tabla AND COLUMN_NAME = :columna";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([':tabla' => $tabla, ':columna' => $columna]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($row['existe']) && intval($row['existe']) > 0;
    }

    private function constraintExiste($tabla, $constraintName) {
        $sql = "SELECT COUNT(*) AS existe FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = :tabla AND CONSTRAINT_NAME = :cname";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([':tabla' => $tabla, ':cname' => $constraintName]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return isset($row['existe']) && intval($row['existe']) > 0;
    }

    private function asegurarEsquemaTablaCodigos() {
        try {
            // Añadir columnas si faltan (usar NULL para evitar fallos por filas existentes)
            if (!$this->columnaExiste('password_reset_tokens', 'id_user')) {
                $this->dbConnection->exec("ALTER TABLE `password_reset_tokens` ADD COLUMN `id_user` INT UNSIGNED NULL");
            }
            if (!$this->columnaExiste('password_reset_tokens', 'codigo')) {
                $this->dbConnection->exec("ALTER TABLE `password_reset_tokens` ADD COLUMN `codigo` VARCHAR(10) NULL");
            }
            if (!$this->columnaExiste('password_reset_tokens', 'fecha_expiracion')) {
                $this->dbConnection->exec("ALTER TABLE `password_reset_tokens` ADD COLUMN `fecha_expiracion` DATETIME NULL");
            }
            if (!$this->columnaExiste('password_reset_tokens', 'activo')) {
                $this->dbConnection->exec("ALTER TABLE `password_reset_tokens` ADD COLUMN `activo` TINYINT(1) NOT NULL DEFAULT 1");
            }

            // Añadir índice para id_user si no existe
            $sqlIdx = "SELECT COUNT(1) AS existe FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'password_reset_tokens' AND INDEX_NAME = 'idx_id_user'";
            $hasIdx = $this->dbConnection->query($sqlIdx)->fetch(PDO::FETCH_ASSOC);
            if (!(isset($hasIdx['existe']) && intval($hasIdx['existe']) > 0)) {
                $this->dbConnection->exec("ALTER TABLE `password_reset_tokens` ADD KEY `idx_id_user` (`id_user`)");
            }

            // Añadir FK si no existe (permitiendo NULL en id_user)
            if (!$this->constraintExiste('password_reset_tokens', 'fk_prt_user')) {
                // Primero asegurar que la tabla user es InnoDB para FK
                $this->dbConnection->exec("ALTER TABLE `password_reset_tokens` ENGINE=InnoDB");
                $this->dbConnection->exec("ALTER TABLE `password_reset_tokens` ADD CONSTRAINT `fk_prt_user` FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE");
            }
        } catch (PDOException $e) {
            // No bloquear por errores de migración suave; solo registrar y continuar
            error_log("Error asegurando esquema de password_reset_tokens: " . $e->getMessage());
        }
    }
    
    /**
     * Guarda el código de verificación en la base de datos
     * @param string $email Email del usuario
     * @param string $codigo Código de verificación
     * @return bool True si se guardó correctamente, False en caso contrario
     */
    public function guardarCodigo($email, $codigo) {
        try {
            // Cargar configuración de correo para obtener tiempo de expiración
            $mailConfig = require MAIN_APP_ROUTE . "../config/mail.php";
            $expiryMinutes = $mailConfig['recovery']['expiry_minutes'];
            
            // Obtenemos el usuario
            $usuario = $this->verificarCorreo($email);
            if (!$usuario) {
                // lastError ya fue seteado en verificarCorreo si aplica
                return false;
            }
            
            // Verificamos que el usuario tenga la propiedad id_user
            if (!isset($usuario->id_user)) {
                $this->lastError = [
                    'type' => 'missing_user_id',
                    'email' => $email
                ];
                return false;
            }
            
            // Verificamos si existe la tabla, si no, la creamos y validamos resultado
            $tablaCreada = $this->crearTablaCodigosRecuperacion();
            if (!$tablaCreada) {
                // No continuar si la tabla no se pudo crear
                if ($this->lastError === null) {
                    $this->lastError = [
                        'type' => 'table_creation_failed'
                    ];
                }
                return false;
            }
            
            // Primero invalidamos cualquier código anterior
            $this->invalidarCodigosAnteriores($usuario->id_user);
            
            // Calculamos la fecha de expiración usando configuración
            $fechaExpiracion = date('Y-m-d H:i:s', strtotime("+{$expiryMinutes} minutes"));
            
            $sql = "INSERT INTO `password_reset_tokens` (`id_user`, `codigo`, `fecha_expiracion`, `activo`) 
                    VALUES (:id_user, :codigo, :fecha_expiracion, 1)";
            
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':id_user', $usuario->id_user, PDO::PARAM_INT);
            $statement->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $statement->bindParam(':fecha_expiracion', $fechaExpiracion, PDO::PARAM_STR);
            
            return $statement->execute();
        } catch (PDOException $e) {
            error_log("Error al guardar código: " . $e->getMessage());
            $this->lastError = [
                'type' => 'db_exception',
                'operation' => 'guardarCodigo',
                'message' => $e->getMessage()
            ];
            return false;
        }
    }
    
    /**
     * Invalida todos los códigos anteriores del usuario
     * @param int $idUsuario ID del usuario
     */
    private function invalidarCodigosAnteriores($idUsuario) {
        try {
            $sql = "UPDATE `password_reset_tokens` SET activo = 0 WHERE id_user = :id_user";
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':id_user', $idUsuario, PDO::PARAM_INT);
            
            return $statement->execute();
        } catch (PDOException $e) {
            // Si la tabla no existe, no hay problema
            $this->lastError = [
                'type' => 'db_exception',
                'operation' => 'invalidarCodigosAnteriores',
                'message' => $e->getMessage()
            ];
            return true;
        }
    }
    
    /**
     * Verifica si el código es válido
     * @param string $email Email del usuario
     * @param string $codigo Código a verificar
     * @return bool|object False si no es válido, objeto con datos del usuario si es válido
     */
    public function verificarCodigo($email, $codigo) {
        try {
            $sql = "SELECT prt.*, u.* FROM `password_reset_tokens` prt
                    INNER JOIN `user` u ON prt.id_user = u.id_user
                    WHERE prt.codigo = :codigo AND u.email = :email
                    AND prt.activo = 1 AND prt.fecha_expiracion > NOW()";
            
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->execute();
            
            $resultado = $statement->fetch(PDO::FETCH_OBJ);
            
            if (!$resultado) {
                return false;
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error al verificar código: " . $e->getMessage());
            $this->lastError = [
                'type' => 'db_exception',
                'operation' => 'verificarCodigo',
                'message' => $e->getMessage()
            ];
            return false;
        }
    }
    
    /**
     * Cambia la contraseña del usuario
     * @param string $email Email del usuario
     * @param string $nuevaContrasenia Nueva contraseña (ya debe venir hasheada)
     * @return bool True si se cambió correctamente, False en caso contrario
     */
    public function cambiarContrasenia($email, $nuevaContrasenia) {
        try {
            $sql = "UPDATE `user` SET password = :password WHERE email = :email";
            
            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':password', $nuevaContrasenia, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            
            $resultado = $statement->execute();
            
            if ($resultado) {
                // Invalidar todos los códigos del usuario después de cambiar la contraseña
                $usuario = $this->verificarCorreo($email);
                if ($usuario) {
                    $this->invalidarCodigosAnteriores($usuario->id_user);
                }
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error al cambiar contraseña: " . $e->getMessage());
            $this->lastError = [
                'type' => 'db_exception',
                'operation' => 'cambiarContrasenia',
                'message' => $e->getMessage()
            ];
            return false;
        }
    }
}