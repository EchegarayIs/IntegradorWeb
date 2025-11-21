<?php
session_start();

require_once '../modelo/conexion/Conexion.php'; 

require_once '../modelo/CheckoutModel.php';



ini_set('display_errors', 0); 
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/phperrors.log'); 
session_start();
header('Content-Type: application/json');

const ID_USUARIO_FICTICIO = 4; 


$idUsuario = $_SESSION['idUsuario'] ?? ID_USUARIO_FICTICIO;
$carrito = $_SESSION['carrito'] ?? []; 

if (empty($carrito)) {
    http_response_code(400); 
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

$checkoutModel = new CheckoutModel();
$resultado = $checkoutModel->confirmarPedidoYPago($montoTotal, $idUsuario, $carrito);

if ($resultado['success']) {
    
   
    unset($_SESSION['carrito']); 
    
    http_response_code(200); 
    echo json_encode([
        'success' => true,
        'message' => 'Pedido confirmado y pagado con ' . $metodoPago,
        'idPedido' => $resultado['idPedido'],
        'monto' => number_format($montoTotal, 2)
    ]);
} else {
    http_response_code(500); 
    echo json_encode([
        'success' => false,
        'message' => 'Error en la transacción de la base de datos.', 
        'detail' => $resultado['detail'] 
    ]);
}

// NO DEBE HABER ETIQUETA DE CIERRE ?> 