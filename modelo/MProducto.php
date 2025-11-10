<?php
require_once "conexion/Conexion.php";

class MProducto {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectar();
    }

    // Método para registrar un producto nuevo (estado y categoría = 1 por defecto)
    public function registrarProducto($nombre, $precio, $imagen) {
        try {
            // Valores por defecto
            $estado = 1;
            $categoria = 1;

            $sql = "INSERT INTO productos (nombre, precio, imagen, estado, categoria)
                    VALUES (:nombre, :precio, :imagen, :estado, :categoria)";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
            $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            return "Error al registrar producto: " . $e->getMessage();
        }
    }
}
?>
