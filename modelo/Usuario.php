<?php
require_once '../modelo/conexion/Conexion.php';

class Usuario {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectar();
    }

    public function registrarUsuario($nombre, $apellidos, $fechaNac, $direccion, $genero, $correo, $passwor) {
        try {
            // Convertir género a número
            $generoValor = ($genero === 'M') ? 1 : (($genero === 'F') ? 2 : 3);
             
            $rol = 1;       
            $estado = 1;    
            

            $sql = "INSERT INTO usuarios (nombre, apellidos, fechaNac, direccion, genero, correo, passwor, Roles_idRol, estado)
                    VALUES (:nombre, :apellidos, :fechaNac, :direccion, :genero, :correo, :passwor, :rol, :estado)";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':fechaNac', $fechaNac);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':genero', $generoValor);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':passwor', $passwor);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':estado', $estado);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al registrar usuario: " . $e->getMessage();
            return false;
        }
    }
    public function registrarUsuario2($nombre, $apellidos, $fechaNac, $direccion, $genero, $correo, $passwor) {
        try {
            // Convertir género a número
            $generoValor = (int)$genero;
             
            $rol = 2;       
            $estado = 1;    
            

            $sql = "INSERT INTO usuarios (nombre, apellidos, fechaNac, direccion, genero, correo, passwor, Roles_idRol, estado)
                    VALUES (:nombre, :apellidos, :fechaNac, :direccion, :genero, :correo, :passwor, :rol, :estado)";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':fechaNac', $fechaNac);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':genero', $generoValor);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':passwor', $passwor);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':estado', $estado);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al registrar usuario: " . $e->getMessage();
            return false;
        }
    }
    


}
?>
