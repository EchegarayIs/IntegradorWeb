<?php
session_start();
require_once "../modelo/conexion/Conexion.php";

class MUsuario {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectar();
    }

    public function validarLogin($usuario, $password) {
        $query = "SELECT idUsuario, nombre, correo, Roles_idRol, password, estado
                  FROM usuarios 
                  WHERE (nombre = :usuario) 
                  AND password = :password 
                  AND estado = 1";

        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
