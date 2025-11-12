<?php
require_once "conexion/Conexion.php";

class MProducto {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectar();
    }

    // Método para registrar un producto nuevo (estado y categoría = 1 por defecto)
    public function registrarProducto($nombre, $precio, $categoria, $imagen ) {
        try {
            // Valores por defecto
            $estado = 1;
        

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
    // ✅ Listar productos de categoría 0
    public function listarTacos() {
        try {
            $sql = "SELECT * FROM productos WHERE categoria = 0";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error al listar productos de categoría 0: " . $e->getMessage();
        }
    }

    // ✅ Listar productos de categoría 1
    public function listarBebidas() {
        try {
            $sql = "SELECT * FROM productos WHERE categoria = 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error al listar productos de categoría 1: " . $e->getMessage();
        }
    }

    // ✅ Listar productos de categoría 2
    public function listarTortas() {
        try {
            $sql = "SELECT * FROM productos WHERE categoria = 2";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error al listar productos de categoría 2: " . $e->getMessage();
        }
    }
    public function buscarPorId($idProductos) {
    try {
        $sql = "SELECT * FROM productos WHERE idProductos = :idProductos LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':idProductos', $idProductos, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    } catch (PDOException $e) {
        return null;
    }
}


    public function editarPrecio($idProductos, $precio) {
    try {
        $sql = "UPDATE productos SET precio = :precio WHERE idProductos = :idProductos";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':idProductos', $idProductos, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}
public function eliminarProducto($idProductos) {
        try {
            $sql = "DELETE FROM productos WHERE idProductos = :idProductos";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idProductos', $idProductos, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
