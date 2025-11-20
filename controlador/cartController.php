<?php

require_once('../modelo/cartModel.php');

$response = ['success' => false, 'message' => 'Operación no válida.', 'total_carrito' => 0.00];

// Inicializar el Modelo
$cart = new cartModel();

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
    

    // AÑADIR PRODUCTO
    
    case 'add':
        $producto_id = filter_input(INPUT_POST, 'producto_id', FILTER_SANITIZE_STRING);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $precio_base = filter_input(INPUT_POST, 'precio_base', FILTER_VALIDATE_FLOAT); 
        $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_INT);

        // Los modificadores vienen como una cadena JSON y deben ser decodificados
        $modificadores_json = $_POST['modificadores_json'] ?? '[]';
        $modificadores = json_decode($modificadores_json, true);
        
        if (!$producto_id || !$nombre || $precio_base === false || $cantidad < 1 || json_last_error() !== JSON_ERROR_NONE) {
            $response['message'] = 'Datos del producto incompletos o inválidos.';
            break;
        }

        if ($cart->addItem($producto_id, $nombre, $precio_base, $cantidad, $modificadores)) {
            $response['success'] = true;
            $response['message'] = 'Producto añadido al carrito.';
        } else {
            $response['message'] = 'Error desconocido al añadir el producto.';
        }
        break;

    
    case 'update':
        $item_hash = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_INT);
        
        if ($cart->updateQuantity($item_hash, $cantidad)) {
            $response['success'] = true;
            $response['message'] = 'Cantidad actualizada.';
        } else {
            $response['message'] = 'Error al actualizar o ítem no encontrado.';
        }
        break;

   
    case 'remove':
        $item_hash = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        
        if ($cart->removeItem($item_hash)) {
            $response['success'] = true;
            $response['message'] = 'Producto eliminado.';
        } else {
            $response['message'] = 'Error al eliminar o ítem no encontrado.';
        }
        break;

    default:
        $response['message'] = 'Acción no reconocida.';
        break;
}

$response['total_carrito'] = number_format($cart->getTotalSubtotal(), 2, '.', '');

header('Content-Type: application/json');
echo json_encode($response);
?>