<?php
// Archivo: App/Models/PerfilModel.php

namespace App\Models;

require_once MAIN_APP_ROUTE . "../models/BaseModel.php";

use PDO;
use PDOException;

class PerfilModel extends BaseModel
{
    // Las propiedades del constructor ya no son necesarias aquí, 
    // ya que el modelo se usa para OBTENER datos, no para contenerlos.

    public function __construct() {
        parent::__construct();
        // Especificamos la tabla correcta. Usamos comillas invertidas porque 'user' es una palabra reservada.
        $this->table = "`user`"; 
    }

    /**
     * Obtiene todos los datos de un usuario específico, incluyendo su rol, grupo y programa de formación.
     * @param int $id El ID del usuario a buscar.
     * @return object|false Un objeto con los datos del usuario o false si no se encuentra.
     */
    public function getUserProfileById(int $id)
    {
        try {
            // Esta es la consulta clave. Une todas las tablas necesarias.
            $sql = "
                SELECT 
                    u.*, 
                    r.name as role_name,
                    g.token_number as group_token,
                    tp.name as program_name,
                    tc.name as center_name
                FROM `user` u
                LEFT JOIN `role` r ON u.id_role = r.id_role
                LEFT JOIN `group` g ON u.id_group = g.id_group
                LEFT JOIN `trainingprogram` tp ON g.id_trainingprogram = tp.id_trainingprogram
                LEFT JOIN `trainingcenter` tc ON tp.id_trainingcenter = tc.id_trainingcenter
                WHERE u.id_user = :id
            ";

            $statement = $this->dbConnection->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            // Usamos fetch() porque solo esperamos un resultado
            $result = $statement->fetch(PDO::FETCH_OBJ); 
            
            return $result;

        } catch (PDOException $ex) {
            // En un entorno de producción, es mejor loguear el error que mostrarlo.
            error_log("Error en PerfilModel::getUserProfileById: " . $ex->getMessage());
            return false;
        }
    }
}