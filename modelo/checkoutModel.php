<?php
// modelo/CheckoutModel.php - CORREGIDO PARA USAR PDO

// La ruta debe ser correcta.
// modelo/CheckoutModel.php
require_once '../modelo/conexion/Conexion.php';

class CheckoutModel {

    private $conexion;

    public function __construct() {
    $con = new Conexion(); // 1. ¿Se puede crear la instancia?
    $this->conexion = $con->conectar(); // 2. ¿Se puede llamar al método conectar()?
}

    public function confirmarPedidoYPago($montoTotal, $idUsuario, $carrito) {
        
        $fechaActual = date('Y-m-d');
        $estadoPedido = 1; 
        $idPedido = 0;

        try {
            // =================================================================
            // INICIO DE TRANSACCIÓN PDO
            // =================================================================
            $this->conexion->beginTransaction();

            // =================================================================
            // PASO 1: Insertar el Pedido principal
            // =================================================================
            // PDO requiere una sintaxis de 'call' diferente y placeholders :param.
            // Los procedimientos almacenados con PDO son más sencillos de llamar:
            $stmt = $this->conexion->prepare("CALL sp_InsertarPedidos(?, ?, ?, ?)"); 
            
            // PDO no tiene bind_param, usamos execute con un array
            if (!$stmt->execute([$montoTotal, $fechaActual, $idUsuario, $estadoPedido])) {
                throw new Exception("Error al ejecutar SP_InsertarPedidos.");
            }
            $stmt = null; // Cerrar el statement

            // Obtener el ID del Pedido recién insertado (usando PDO: lastInsertId)
            $idPedido = $this->conexion->lastInsertId();
            
            if ($idPedido <= 0) {
                 throw new Exception("Error al obtener el ID del pedido principal.");
            }

            // =================================================================
            // PASO 2: Insertar los Productos del Pedido (Bucle por cada item)
            // =================================================================
            $stmt = $this->conexion->prepare("CALL sp_Insertar_ProdHasPed(?, ?, ?)"); 

            foreach ($carrito as $item) {
                // 🛑 AJUSTAR CLAVES DE CARRO AQUÍ 🛑 (usando 'id' y 'cant' como ejemplo)
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


            // =================================================================
            // PASO 3: Insertar el Pago
            // =================================================================
            $stmt = $this->conexion->prepare("CALL sp_InsertarPagos(?, ?)"); 
            
            if (!$stmt->execute([$montoTotal, $idPedido])) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Error al insertar el registro de pago. Detalle DB: " . $errorInfo[2]);
            }
            $stmt = null;

            // =================================================================
            // PASO 4: Confirmar la Transacción (COMMIT)
            // =================================================================
            $this->conexion->commit();
            return [
                "success" => true,
                "message" => "Transacción exitosa",
                "idPedido" => $idPedido,
                "detail" => "Transacción completada"
            ];

        } catch (Exception $e) {
            // Deshacer la Transacción (ROLLBACK) si algo falló
            $this->conexion->rollBack(); // <--- Método PDO: rollBack()
            return [
                "success" => false,
                "message" => "Fallo en la transacción de la DB.", 
                "detail" => $e->getMessage() 
            ];
        }
    }
}