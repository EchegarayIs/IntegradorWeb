<?php
require_once "conexion/Conexion.php";

class MPedido {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectar();
    }


        public function listarPedidosPorUsuario($idUsuario) {
        $query = "SELECT idPedido, monto, fechaPedido, usuario_idUsuario, estado
                  FROM pedidos 
                  WHERE usuario_idUsuario = :idUsuario
                  ORDER BY fechaPedido DESC";

        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarPedido($idUsuario, $total, $metodoPago, $carrito) {
        
        $estado = 1; 
        
        try {
            $this->conexion->beginTransaction();


            $sqlPedido = "INSERT INTO pedidos (usuario_idUsuario, monto, fechaPedido, estado)
                          VALUES (:idUsuario, :monto, :fechaPedido, :estado)";
            $stmtPedido = $this->conexion->prepare($sqlPedido);
            
            $fechaActual = date('Y-m-d');
            
            $stmtPedido->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmtPedido->bindParam(':monto', $total, PDO::PARAM_STR); 
            $stmtPedido->bindParam(':fechaPedido', $fechaActual, PDO::PARAM_STR);
            $stmtPedido->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmtPedido->execute();
            
            $idPedido = $this->conexion->lastInsertId();

            $sqlPago = "INSERT INTO pagos (Pedidos_idPedidos, monto, metodoPago)
                        VALUES (:idPedido, :monto, :metodoPago)";
            $stmtPago = $this->conexion->prepare($sqlPago);
            
            $stmtPago->bindParam(':idPedido', $idPedido, PDO::PARAM_INT); // Usamos idPedido como valor
            $stmtPago->bindParam(':monto', $total, PDO::PARAM_STR);
            $stmtPago->bindParam(':metodoPago', $metodoPago, PDO::PARAM_STR);
            $stmtPago->execute();

            $this->conexion->commit();
            return $idPedido; // Devolvemos el ID del pedido

        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            
            throw new Exception("Error SQL al registrar pedido: " . $e->getMessage()); 
        }
    }
    public function pedidosEspera() {
    $query = "SELECT idPedido, monto, fechaPedido, usuario_idUsuario, estado 
              FROM pedidos 
              WHERE estado = 1
              ORDER BY fechaPedido DESC";

    $stmt = $this->conexion->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function actualizarEstadoPedido($idPedido) {
    try {
        $query = "UPDATE pedidos 
                  SET estado = estado + 1 
                  WHERE idPedido = :idPedido";

        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":idPedido", $idPedido, PDO::PARAM_INT);

        return $stmt->execute();
    } catch (PDOException $e) {
        return "Error al actualizar estado del pedido: " . $e->getMessage();
    }
}
public function pedidosProceso() {
    $query = "SELECT idPedido, monto, fechaPedido, usuario_idUsuario, estado 
              FROM pedidos 
              WHERE estado = 2
              ORDER BY fechaPedido DESC";

    $stmt = $this->conexion->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function pedidosTerminados() {
    $query = "SELECT idPedido, monto, fechaPedido, usuario_idUsuario, estado 
              FROM pedidos 
              WHERE estado = 3
              ORDER BY fechaPedido DESC";

    $stmt = $this->conexion->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
?>