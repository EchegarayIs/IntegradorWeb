<?php
/**
 * Controlador para manejar las operaciones del carrito.
 * Incluye acciones: 'add' (agregar), 'remove' (eliminar), 'update' (actualizar cantidad).
 */

// Debe ser lo primero
session_start();

// Establecer la cabecera para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Función de utilidad para calcular el total del carrito (usada en todas las respuestas)
function calcularTotalCarrito() {
    $total = 0;
    // Usamos el array de la sesión directamente
    $carrito = $_SESSION['carrito'] ?? [];
    foreach ($carrito as $item) {
        $total += $item['subtotal'];
    }
    // Devolvemos el total formateado
    return number_format($total, 2, '.', ''); 
}

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// -----------------------------------------------------------
// 3. PROCESAR LA ACCIÓN (Recibida por AJAX)
// -----------------------------------------------------------
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $response = ['success' => false, 'message' => ''];
    $id = intval($_POST['id'] ?? 0);
    
    // --- ACCIÓN: AGREGAR PRODUCTO DESDE EL MENÚ ('add') ---
    if ($action === 'add') {
        $nombre = htmlspecialchars($_POST['nombre'] ?? '');
        $precio = floatval($_POST['precio'] ?? 0.00);
        $cantidad = intval($_POST['cantidad'] ?? 0);

        if ($id > 0 && $cantidad > 0 && $precio >= 0) {
            
            // Revisa si el producto ya está y suma la cantidad
            if (isset($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
                $_SESSION['carrito'][$id]['subtotal'] = $_SESSION['carrito'][$id]['precio'] * $_SESSION['carrito'][$id]['cantidad'];
            } else {
                // Añadir nuevo producto
                $_SESSION['carrito'][$id] = [
                    'id' => $id,
                    'nombre' => $nombre,
                    'precio' => $precio,
                    'cantidad' => $cantidad,
                    'subtotal' => $precio * $cantidad
                ];
            }
            $response['success'] = true;
            $response['message'] = "Producto agregado/actualizado exitosamente.";
        } else {
            http_response_code(400); 
            $response['message'] = "Error: Datos de producto inválidos para agregar.";
        }
    }

    // --- ACCIÓN: ACTUALIZAR CANTIDAD DESDE EL CARRITO ('update') ---
    elseif ($action === 'update') {
        $nueva_cantidad = intval($_POST['cantidad'] ?? 0);

        if ($id > 0 && isset($_SESSION['carrito'][$id])) {
            
            if ($nueva_cantidad > 0) {
                // Actualiza la cantidad y el subtotal
                $_SESSION['carrito'][$id]['cantidad'] = $nueva_cantidad;
                $_SESSION['carrito'][$id]['subtotal'] = $_SESSION['carrito'][$id]['precio'] * $nueva_cantidad;
                $response['success'] = true;
                $response['message'] = "Cantidad actualizada.";
                $response['new_subtotal'] = number_format($_SESSION['carrito'][$id]['subtotal'], 2, '.', '');

            } else {
                // Si la cantidad es 0, se elimina del carrito
                unset($_SESSION['carrito'][$id]);
                $response['success'] = true;
                $response['message'] = "Producto eliminado (cantidad 0).";
            }

        } else {
            http_response_code(404);
            $response['message'] = "Error: Producto no encontrado para actualizar.";
        }
    }
    
    // --- ACCIÓN: ELIMINAR PRODUCTO DESDE EL CARRITO ('remove') ---
    elseif ($action === 'remove') {
        if ($id > 0 && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
            $response['success'] = true;
            $response['message'] = "Producto eliminado correctamente.";
        } else {
            http_response_code(404);
            $response['message'] = "Producto no encontrado en el carrito para eliminar.";
        }
    }
    
    // -----------------------------------------------------------
    // Incluir el total actualizado en todas las respuestas exitosas
    // -----------------------------------------------------------
    if ($response['success']) {
        $response['total_carrito'] = calcularTotalCarrito();
    }
    
    echo json_encode($response);
    exit;

} else {
    // Si no es una petición POST válida, devolvemos error 
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => "Petición POST no recibida o sin acción."]);
    exit;
}
?>