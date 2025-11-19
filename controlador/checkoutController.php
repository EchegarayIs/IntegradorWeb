<?php
// controlador/C_Checkout.php - Controlador para preparar la vista de checkout

// CRÍTICO: Iniciar sesión (para el carrito y usuario)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Lógica de Conexión (Necesaria si usas MProducto/MUsuario, aunque solo para el cálculo no lo es)
// Si necesitas alguna función del modelo, asegúrate de incluirla aquí, no en la vista.
// require_once('../modelo/conexion/Conexion.php'); 

// 2. Definición de Variables desde la Sesión
$carrito = $_SESSION['carrito'] ?? [];
$nombre_usuario = $_SESSION['nombre'] ?? 'Invitado'; 
$id_usuario_actual = $_SESSION['idUsuario'] ?? 10; // Usaremos 10 si no hay sesión

// 3. Variables de Cálculo
$total_subtotal = 0.00; 
$SHIPPING_COST = 0.00; // Define el costo de envío
$is_cart_empty = empty($carrito); // Para deshabilitar botones si no hay nada

// 4. Cálculo del Total del Pedido
foreach ($carrito as $item) {
    // Aseguramos que el subtotal es numérico antes de sumarlo
    $subtotal = is_numeric($item['subtotal']) ? (float)$item['subtotal'] : 0.00;
    $total_subtotal += $subtotal;
}

$total_final = $total_subtotal + $SHIPPING_COST;

// 5. Formato para pasar a JavaScript (CRÍTICO para la llamada AJAX)
$total_final_js = number_format($total_final, 2, '.', '');

// 6. Ahora todas estas variables ($carrito, $total_final, etc.) estarán disponibles para checkout.php
?>