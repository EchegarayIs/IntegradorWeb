<?php
class Conexion {
    private $host = "localhost";
    private $db   = "dbintegrador";
    private $user = "root";
    private $pass = "";
    private $charset = "utf8mb4";

    public function conectar() {
        try {
            $conexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->exec("SET NAMES " . $this->charset);
            return $conexion;
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}
?>
