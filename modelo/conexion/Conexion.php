<?php
class Conexion {
    private $host = "localhost";
    private $db   = "dbintegrador";
    private $user = "root";
<<<<<<< HEAD
    private $pass = "qwerty1234.";
=======
    private $pass = "123456";
>>>>>>> 97ea89d37e1c817448f42cf3e12e5d9082255f8f
    private $charset = "utf8mb4";

    public function conectar() {
        try {
            $conexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->exec("SET NAMES " . $this->charset);
            return $conexion;
        } catch (PDOException $e) {
            // Un die() aquí garantiza que el error sea visible si la conexión falla.
            die("Fallo FATAL en la conexión: " . $e->getMessage());
        }
    }
}