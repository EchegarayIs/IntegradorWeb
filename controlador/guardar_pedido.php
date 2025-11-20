<?php
// guardar_pedido.php
session_start();

// 1. Incluir la clase de conexión y verificar el carrito
require_once 'Conexion.php'; // Asegúrate de que la ruta sea correcta

if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(['success' => false, 'message' => 'Error: Usuario no autenticado.']);
    exit;
}

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo json_encode(['success' => false, 'message' => 'Error: El carrito está vacío.']);
    exit;
}

// 2. Obtener datos necesarios
$usuario_id = $_SESSION['idUsuario'];
$metodo_pago = $_POST['metodo'] ?? 'Efectivo'; // 'Efectivo' o 'Tarjeta'
$total_pedido = 0;

// Calcular el total final del carrito (seguridad en el servidor)
foreach ($_SESSION['carrito'] as $producto) {
    $total_pedido += $producto['precio'] * $producto['cantidad'];
}

$conn = (new Conexion())->getConexion();
$conn->autocommit(FALSE); // Iniciar Transacción
$all_ok = true;

try {
    // --- INSERTAR EN LA TABLA PEDIDOS ---
    // estado: 1 (Pagado/Confirmado), 0 (Pendiente/Cancelado)
    $stmt_pedido = $conn->prepare("INSERT INTO pedidos (monto, fechaPedido, usuario_idUsuario, estado) VALUES (?, CURDATE(), ?, 1)");
    $stmt_pedido->bind_param("di", $total_pedido, $usuario_id);

    if (!$stmt_pedido->execute()) {
        throw new Exception("Error al insertar el pedido: " . $stmt_pedido->error);
    }
    
    // Obtener el ID del pedido recién insertado
    $id_pedido = $conn->insert_id;
    $stmt_pedido->close();


    // --- INSERTAR EN LA TABLA PEDIDOS_HAS_PRODUCTOS ---
    $stmt_detalle = $conn->prepare("INSERT INTO pedidos_has_productos (idPedido, idProducto, cantidadProducto, montoProductos) VALUES (?, ?, ?, ?)");
    
    foreach ($_SESSION['carrito'] as $item) {
        $id_producto = $item['id'];
        $cantidad = $item['cantidad'];
        $precio_total_producto = $item['precio'] * $item['cantidad'];
        
        // El campo 'idProducto' en tu carrito debe contener el idProductos de la tabla 'productos'
        $stmt_detalle->bind_param("iidi", $id_pedido, $id_producto, $cantidad, $precio_total_producto);
        
        if (!$stmt_detalle->execute()) {
             throw new Exception("Error al insertar detalle de producto (ID: $id_producto): " . $stmt_detalle->error);
        }
    }
    $stmt_detalle->close();

    
    // --- INSERTAR EN LA TABLA PAGOS ---
    // Usamos el ID del pedido como FK para la tabla pagos.
    $stmt_pago = $conn->prepare("INSERT INTO pagos (monto, Pedidos_idPedidos, metodo_pago) VALUES (?, ?)"); // Necesitas añadir la columna metodo_pago en tu tabla pagos
    
    // NOTA IMPORTANTE DE ESQUEMA:
    $stmt_pago_simple = $conn->prepare("INSERT INTO pagos (monto, Pedidos_idPedidos) VALUES (?, ?)");
    $stmt_pago_simple->bind_param("di", $total_pedido, $id_pedido);
    
    if (!$stmt_pago_simple->execute()) {
         throw new Exception("Error al insertar el registro de pago: " . $stmt_pago_simple->error);
    }
    $stmt_pago_simple->close();


    $conn->commit();
    unset($_SESSION['carrito']);

    echo json_encode([
        'success' => true,
        'message' => '¡Pedido completado con éxito!',
        'id_pedido' => $id_pedido
    ]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        'success' => false, 
        'message' => 'Error en el procesamiento del pedido: ' . $e->getMessage()
    ]);
    
} finally {
    $conn->close();
}
?>