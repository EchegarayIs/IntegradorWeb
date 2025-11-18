<?php
require_once "../modelo/conexion/Conexion.php";

class MUsuario {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectar();
    }

    public function validarLogin($usuario, $passwor) {
        $query = "SELECT idUsuario, nombre, apellidos, fechaNac, direccion, genero, correo, passwor, Roles_idRol, estado
                  FROM usuarios 
                  WHERE (nombre = :usuario OR correo = :usuario)
                  AND passwor = :passwor
                  AND estado = 1";

        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->bindParam(":passwor", $passwor, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function editarUsuario($idUsuario, $nombre, $apellidos, $fechaNac, $direccion, $genero, $correo, $passwor) {
    $query = "UPDATE usuarios 
              SET nombre = :nombre, 
                  apellidos = :apellidos, 
                  fechaNac = :fechaNac, 
                  direccion = :direccion, 
                  genero = :genero, 
                  correo = :correo, 
                  passwor = :passwor 
              WHERE idUsuario = :idUsuario";

    $stmt = $this->conexion->prepare($query);
    $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
    $stmt->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
    $stmt->bindParam(":fechaNac", $fechaNac, PDO::PARAM_STR);
    $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
    $stmt->bindParam(":genero", $genero, PDO::PARAM_INT);
    $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
    $stmt->bindParam(":passwor", $passwor, PDO::PARAM_STR);
    $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);

    return $stmt->execute();
}
}
?>

