<?php
// controlador/procesar_pago.php

// === 1. PRUEBA: Si no ves "A.", el problema es el servidor o la sintaxis inicial === 


// === INCLUSIONES NECESARIAS ===
// Si el controlador está en 'controlador/' y el modelo en 'modelo/', la ruta es correcta.
require_once '../modelo/conexion/Conexion.php'; 
// === 2. PRUEBA: Si sale 500 aquí, la ruta de la CONEXIÓN está mal ===



require_once '../modelo/CheckoutModel.php';
// === 3. PRUEBA: Si sale 500 aquí, el MODELO tiene un error de sintaxis ===


// === CONFIGURACIÓN Y ENCABEZADOS ===
ini_set('display_errors', 0); 
ini_set('log_errors', 1);
// Puedes crear un archivo phperrors.log en la raíz de tu proyecto para ver los fallos
ini_set('error_log', dirname(__DIR__) . '/phperrors.log'); 
session_start();
header('Content-Type: application/json');

// Define el ID de usuario único que utilizaremos temporalmente
const ID_USUARIO_FICTICIO = 10; 

// === 1. Asignación del ID y Verificación de Carrito ===
$idUsuario = ID_USUARIO_FICTICIO;
$carrito = $_SESSION['carrito'] ?? []; 

if (empty($carrito)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Carrito vacío.']);
    exit;
}

if (!isset($_POST['montoTotal'])) {
    http_response_code(400); 
    echo json_encode(['success' => false, 'message' => 'Falta el monto total del pedido.']);
    exit;
}
$montoTotal = (float)$_POST['montoTotal'];
$metodoPago = $_POST['metodoPago'] ?? 'Desconocido';

// === 2. Ejecutar la Transacción del Modelo ===
$checkoutModel = new CheckoutModel();
$resultado = $checkoutModel->confirmarPedidoYPago($montoTotal, $idUsuario, $carrito);


// === 3. Manejo de Respuesta y Limpieza ===
if ($resultado['success']) {
    
    // **Limpiar el carrito después de una transacción exitosa**
    unset($_SESSION['carrito']); 
    
    http_response_code(200); // OK
    echo json_encode([
        'success' => true,
        'message' => 'Pedido confirmado y pagado con ' . $metodoPago,
        'idPedido' => $resultado['idPedido'],
        'monto' => number_format($montoTotal, 2)
    ]);
} else {
    // Si hubo un ROLLBACK
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Error en la transacción de la base de datos.', 
        // ¡IMPORTANTE! Aquí obtenemos el detalle del error de PDO/PHP
        'detail' => $resultado['detail'] 
    ]);
}

// NO DEBE HABER ETIQUETA DE CIERRE ?> NI ESPACIOS/SALTOS DE LÍNEA AQUÍ!