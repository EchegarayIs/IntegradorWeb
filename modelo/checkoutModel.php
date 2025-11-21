<?php
// modelo/CheckoutModel.php - CORREGIDO PARA USAR PDO

// La ruta debe ser correcta.
// modelo/CheckoutModel.php
require_once '../modelo/conexion/Conexion.php';

class CheckoutModel {

    private $conexion;

    public function __construct() {
    $con = new Conexion();
    $this->conexion = $con->conectar();
}

    public function confirmarPedidoYPago($montoTotal, $idUsuario, $carrito) {
        
        $fechaActual = date('Y-m-d');
        $estadoPedido = 1; 
        $idPedido = 0;

        try {

            $this->conexion->beginTransaction();

            $stmt = $this->conexion->prepare("CALL sp_InsertarPedidos(?, ?, ?, ?)"); 
            
           
            if (!$stmt->execute([$montoTotal, $fechaActual, $idUsuario, $estadoPedido])) {
                throw new Exception("Error al ejecutar SP_InsertarPedidos.");
            }
            $stmt = null; // Cerrar el statement

            $idPedido = $this->conexion->lastInsertId();
            
            if ($idPedido <= 0) {
                 throw new Exception("Error al obtener el ID del pedido principal.");
            }

            $stmt = $this->conexion->prepare("CALL sp_Insertar_ProdHasPed(?, ?, ?)"); 

            foreach ($carrito as $item) {
                $idProducto = $item['id'] ?? $item['idProducto'] ?? null; 
                $cantidad = $item['cant'] ?? $item['cantidad'] ?? null; 
                
                if ($idProducto === null || $cantidad === null || $idProducto == 0 || $cantidad == 0) {
                    throw new Exception("Error de datos en carrito: El producto ID o la cantidad no son válidos.");
                }

                if (!$stmt->execute([$idProducto, $idPedido, $cantidad])) {
                    $errorInfo = $stmt->errorInfo();
                    throw new Exception("Error al insertar producto $idProducto. Detalle DB: " . $errorInfo[2]);
                }
            }
            $stmt = null;

            $stmt = $this->conexion->prepare("CALL sp_InsertarPagos(?, ?)"); 
            
            if (!$stmt->execute([$montoTotal, $idPedido])) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Error al insertar el registro de pago. Detalle DB: " . $errorInfo[2]);
            }
            $stmt = null;

            $this->conexion->commit();
            return [
                "success" => true,
                "message" => "Transacción exitosa",
                "idPedido" => $idPedido,
                "detail" => "Transacción completada"
            ];

        } catch (Exception $e) {
            $this->conexion->rollBack(); // Método PDO rollBack()
            return [
                "success" => false,
                "message" => "Fallo en la transacción de la DB.", 
                "detail" => $e->getMessage() 
            ];
        }
    }
}