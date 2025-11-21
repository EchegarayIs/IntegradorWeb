<?php

session_start();

header('Content-Type: application/json');

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}


/**
 * Genera un ID único (Hash) basado en el producto y sus mods.
 * @param string $producto_id El ID base del producto.
 * @param array $modificadores El array de objetos de modificadores.
 * @return string El hash único.
 */
function generateItemHash($producto_id, $modificadores) {
    $modificadores = $modificadores ?? [];
    $mod_names = array_column($modificadores, 'nombre');
    sort($mod_names); 
    $mod_string = implode('|', $mod_names);
    return md5($producto_id . ':' . $mod_string);
}

/**
 * Calcula el costo extra total de los modificadores.
 * @param array $modificadores
 * @return float El costo extra total.
 */
function calculateModsCost($modificadores) {
    $costo = 0.00;
    $modificadores = $modificadores ?? [];
    foreach ($modificadores as $mod) {
        $costo += (float)($mod['precio_extra'] ?? 0.00);
    }
    return $costo;
}

/**
 * Recalcula el subtotal para todos los ítems del carrito.
 * CRÍTICO: Esto asegura que el total del carrito y el subtotal de cada ítem sean correctos.
 * @return float El subtotal total del carrito.
 */
function calcularTotalCarrito() {
    $total_subtotal = 0.00;
    
    
    foreach ($_SESSION['carrito'] as $item_hash => &$item) {
        
        $base_cost_unit = (float)($item['precio'] ?? 0.00);
        $mods_cost_unit = calculateModsCost($item['modificadores'] ?? []);
        
        
        $precio_unitario_real = $base_cost_unit + $mods_cost_unit;
        
       
        $item['subtotal'] = $precio_unitario_real * (int)($item['cantidad'] ?? 0);
        
        $total_subtotal += $item['subtotal'];
    }
    
    return number_format($total_subtotal, 2, '.', ''); 
}



if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $response = ['success' => false, 'message' => ''];
    
    $item_hash = $_POST['id'] ?? ''; 
    
    if ($action === 'add') {
        $producto_id = $_POST['producto_id'] ?? '';
        $nombre = htmlspecialchars($_POST['nombre'] ?? '');
        $precio_base = floatval($_POST['precio_base'] ?? 0.00);
        $cantidad = intval($_POST['cantidad'] ?? 0);
        
        $modificadores_json = $_POST['modificadores_json'] ?? '[]';
        $modificadores = json_decode($modificadores_json, true);

        if ($producto_id && $cantidad > 0 && $precio_base >= 0 && json_last_error() === JSON_ERROR_NONE) {
            
            $item_hash_unico = generateItemHash($producto_id, $modificadores);
            
           
            if (isset($_SESSION['carrito'][$item_hash_unico])) {
                $_SESSION['carrito'][$item_hash_unico]['cantidad'] += $cantidad;
            } else {
                /
                $_SESSION['carrito'][$item_hash_unico] = [
                    'producto_id' => $producto_id, // Guardamos el ID 
                    'nombre' => $nombre,
                    'precio' => $precio_base, // Es el precio unitario BASE
                    'cantidad' => $cantidad,
                    'modificadores' => $modificadores, 
                ];
            }
            $response['success'] = true;
            $response['message'] = "Producto agregado/actualizado exitosamente.";
        } else {
            http_response_code(400); 
            $response['message'] = "Error: Datos de producto inválidos para agregar.";
        }
    }

    elseif ($action === 'update') {
        $nueva_cantidad = intval($_POST['cantidad'] ?? 0);

        
        if ($item_hash && isset($_SESSION['carrito'][$item_hash])) {
            
            if ($nueva_cantidad > 0) {
                // Solo actualiza la cantidad (el subtotal se recalculará en el total)
                $_SESSION['carrito'][$item_hash]['cantidad'] = $nueva_cantidad;
                $response['success'] = true;
                $response['message'] = "Cantidad actualizada.";
            } else {
                // Si la cantidad es 0, se elimina del carrito
                unset($_SESSION['carrito'][$item_hash]);
                $response['success'] = true;
                $response['message'] = "Producto eliminado (cantidad 0).";
            }
        } else {
            http_response_code(404);
            $response['message'] = "Error: Producto no encontrado para actualizar.";
        }
    }
    
    /
    elseif ($action === 'remove') {
        
        if ($item_hash && isset($_SESSION['carrito'][$item_hash])) {
            unset($_SESSION['carrito'][$item_hash]);
            $response['success'] = true;
            $response['message'] = "Producto eliminado correctamente.";
        } else {
            http_response_code(404);
            $response['message'] = "Producto no encontrado en el carrito para eliminar.";
        }
    }
    
   
    if ($response['success']) {
        $response['total_carrito'] = calcularTotalCarrito();
        
    }
    
    echo json_encode($response);
    exit;

} else {
    
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => "Petición POST no recibida o sin acción."]);
    exit;
}
?>