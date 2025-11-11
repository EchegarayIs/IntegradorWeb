<?php
require_once "../modelo/conexion/Conexion.php";

class MPedido {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectar();
    }

    //  Listar pedidos por usuario
    public function listarPedidosPorUsuario($idUsuario) {
        $query = "SELECT idPedido, monto, fechaPedido, usuario_idUsuario, estado, idPago 
                  FROM pedidos 
                  WHERE usuario_idUsuario = :idUsuario
                  ORDER BY fechaPedido DESC";

        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function eliminarPedido($idPedido) {
        $query = "DELETE FROM pedidos WHERE idPedido = :idPedido";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":idPedido", $idPedido, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
