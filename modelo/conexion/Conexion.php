<?php
class Conexion {
    private $host = "localhost";
    private $db   = "dbintegrador1";
    private $user = "root";
<<<<<<< HEAD
    private $pass = "123456";
=======
    private $pass = "qwerty1234.";
>>>>>>> 3afbec3e6a085baabd9f732d37aed29e60ad990c
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

    public function cerrarConexion() {
        $this->conexion = null;
    }
}