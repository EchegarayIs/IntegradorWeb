<?php
// modelo/MPedido.php

// Asegúrate de que esta ruta sea correcta para tu clase de conexión
require_once "conexion/Conexion.php";

class MPedido {
    private $conexion;

    public function __construct() {
        // Inicializa la conexión a la base de datos
        $this->conexion = (new Conexion())->conectar();
    }

    /**
     * Registra un nuevo pedido SÓLO en la tabla 'pedidos'.
     * Los detalles del carrito ya no se insertan, pues la tabla 'detalle_pedido' no existe.
     * @param int $idUsuario ID del usuario (o 100 por defecto, lo que usa ApiPedidos.php).
     * @param float $total Monto total del pedido.
     * @param string $metodoPago Método de pago elegido (No se usa por ahora en el SQL).
     * @param array $carrito El array $_SESSION['carrito'] (No se usa por ahora).
     * @return int|bool El ID del pedido insertado si tiene éxito, o false si falla.
     */
    public function registrarPedido($idUsuario, $total, $metodoPago, $carrito) {
        
        // Estado: 1 es 'En espera' (asumiendo que 1 es un estado válido en tu tabla 'estado').
        $estado = 1; 
        
        try {
            // 1. INICIAR TRANSACCIÓN
            $this->conexion->beginTransaction();

            // 2. INSERTAR EL PEDIDO PRINCIPAL (TABLA 'pedidos')
            $sqlPedido = "INSERT INTO pedidos (usuario_idUsuario, monto, fechaPedido, estado)
                          VALUES (:idUsuario, :monto, :fechaPedido, :estado)";
            $stmtPedido = $this->conexion->prepare($sqlPedido);
            
            // Definir la fecha actual (requerida por tu tabla)
            $fechaActual = date('Y-m-d');
            
            $stmtPedido->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $stmtPedido->bindParam(':monto', $total, PDO::PARAM_STR); 
            $stmtPedido->bindParam(':fechaPedido', $fechaActual, PDO::PARAM_STR);
            $stmtPedido->bindParam(':estado', $estado, PDO::PARAM_INT);
            $stmtPedido->execute();
            
            // Obtener el ID del pedido recién insertado
            $idPedido = $this->conexion->lastInsertId();

            //INSERTAR EL REGISTRO DE PAGO (TABLA 'pagos')
            $sqlPago = "INSERT INTO pagos (Pedidos_idPedidos, monto, metodoPago)
                        VALUES (:idPedido, :monto, :metodoPago)";
            $stmtPago = $this->conexion->prepare($sqlPago);
            
            $stmtPago->bindParam(':idPedido', $idPedido, PDO::PARAM_INT); // Usamos idPedido como valor
            $stmtPago->bindParam(':monto', $total, PDO::PARAM_STR);
            $stmtPago->bindParam(':metodoPago', $metodoPago, PDO::PARAM_STR);
            $stmtPago->execute();
            // El campo fechaPago se llena automáticamente


            //3. SE ELIMINÓ la inserción de detalles del pedido ya que la tabla 'detalle_pedido' no existe.

            // 4. CONFIRMAR: Todo está bien, guardamos los cambios.
            $this->conexion->commit();
            return $idPedido; // Devolvemos el ID del pedido

        } catch (PDOException $e) {
            // 5. REVERTIR: Si algo falló.
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            
            //LANZAR el error exacto para que ApiPedidos.php lo muestre en el navegador
            throw new Exception("Error SQL al registrar pedido: " . $e->getMessage()); 
        }
    }
    public function pedidosEspera() {
    $query = "SELECT idPedido, monto, fechaPedido, usuario_idUsuario, estado, idPago 
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


}
?>