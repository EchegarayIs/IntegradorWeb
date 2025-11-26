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
public function listarUsuariosRol2() {
    $query = "SELECT idUsuario, nombre, apellidos, fechaNac, direccion, genero, correo, Roles_idRol, estado
              FROM usuarios
              WHERE Roles_idRol = 2 AND estado = 1";

    $stmt = $this->conexion->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function actualizarUsuario2($idUsuario, $nombre, $apellidos, $fechaNac, $direccion, $genero, $correo, $passwor) {
    try {

        // Convertir género a número
        $generoValor = (int)$genero;

        $sql = "UPDATE usuarios 
                SET nombre = :nombre,
                    apellidos = :apellidos,
                    fechaNac = :fechaNac,
                    direccion = :direccion,
                    genero = :genero,
                    correo = :correo,
                    passwor = :passwor
                WHERE idUsuario = :idUsuario";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':fechaNac', $fechaNac);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':genero', $generoValor);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':passwor', $passwor);

        return $stmt->execute();

    } catch (PDOException $e) {
        echo "Error al actualizar usuario: " . $e->getMessage();
        return false;
    }
}
public function borrarUsuario2($idUsuario) {
    try {
        $sql = "DELETE FROM usuarios WHERE idUsuario = :idUsuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        return $stmt->execute();

    } catch (PDOException $e) {
        echo "Error al eliminar usuario: " . $e->getMessage();
        return false;
    }
} 
public function buscarUsuarioPorId($idUsuario) {
    try {
        $sql = "SELECT idUsuario, nombre, apellidos, fechaNac, direccion, genero, correo, passwor, Roles_idRol, estado
                FROM usuarios 
                WHERE idUsuario = :idUsuario";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return false; // 
    }
}
}
?>

