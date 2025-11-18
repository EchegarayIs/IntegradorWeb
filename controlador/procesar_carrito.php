<?php
/**
 * Controlador para manejar las operaciones del carrito con soporte para Modificadores (Complementos).
 * CRÍTICO: Utiliza un "hash" único (ID de Producto + Modificadores) como clave.
 */

// Debe ser lo primero
session_start();

// Establecer la cabecera para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// -----------------------------------------------------------
// 1. FUNCIONES AUXILIARES (Lógica de Modificaciones y Hash)
// -----------------------------------------------------------

/**
 * Genera un ID único (Hash) basado en el producto y sus mods.
 * @param string $producto_id El ID base del producto.
 * @param array $modificadores El array de objetos de modificadores.
 * @return string El hash único.
 */
function generateItemHash($producto_id, $modificadores) {
    $modificadores = $modificadores ?? [];
    $mod_names = array_column($modificadores, 'nombre');
    // Ordenamos alfabéticamente para que el hash sea el mismo sin importar el orden de selección
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
    
    // Usamos referencia (&) para modificar el ítem en la sesión directamente
    foreach ($_SESSION['carrito'] as $item_hash => &$item) {
        
        $base_cost_unit = (float)($item['precio'] ?? 0.00);
        $mods_cost_unit = calculateModsCost($item['modificadores'] ?? []);
        
        // El precio unitario real (base + mods)
        $precio_unitario_real = $base_cost_unit + $mods_cost_unit;
        
        // Recalcular el subtotal del ítem
        $item['subtotal'] = $precio_unitario_real * (int)($item['cantidad'] ?? 0);
        
        $total_subtotal += $item['subtotal'];
    }
    
    return number_format($total_subtotal, 2, '.', ''); 
}


// -----------------------------------------------------------
// 2. PROCESAR LA ACCIÓN (Recibida por AJAX)
// -----------------------------------------------------------
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $response = ['success' => false, 'message' => ''];
    // CRÍTICO: La clave ahora debe ser una cadena (el hash)
    $item_hash = $_POST['id'] ?? ''; 
    
    // --- ACCIÓN: AGREGAR PRODUCTO DESDE EL MENÚ ('add') ---
    if ($action === 'add') {
        $producto_id = $_POST['producto_id'] ?? '';
        $nombre = htmlspecialchars($_POST['nombre'] ?? '');
        $precio_base = floatval($_POST['precio_base'] ?? 0.00);
        $cantidad = intval($_POST['cantidad'] ?? 0);
        // CRÍTICO: Decodificar el JSON de modificadores
        $modificadores_json = $_POST['modificadores_json'] ?? '[]';
        $modificadores = json_decode($modificadores_json, true);

        if ($producto_id && $cantidad > 0 && $precio_base >= 0 && json_last_error() === JSON_ERROR_NONE) {
            
            // CRÍTICO: Generar hash único para el ítem
            $item_hash_unico = generateItemHash($producto_id, $modificadores);
            
            // El subtotal se calculará en la función calcularTotalCarrito()
            
            // Revisa si el hash ya existe y suma la cantidad
            if (isset($_SESSION['carrito'][$item_hash_unico])) {
                $_SESSION['carrito'][$item_hash_unico]['cantidad'] += $cantidad;
            } else {
                // Añadir nuevo producto con modificadores
                $_SESSION['carrito'][$item_hash_unico] = [
                    'producto_id' => $producto_id, // Guardamos el ID base original
                    'nombre' => $nombre,
                    'precio' => $precio_base, // Es el precio unitario BASE
                    'cantidad' => $cantidad,
                    'modificadores' => $modificadores, // CRÍTICO: Almacenar los modificadores
                    'subtotal' => 0.00 // Se recalculará en la función de total
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

        // CRÍTICO: Usar el hash como clave
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
    
    // --- ACCIÓN: ELIMINAR PRODUCTO DESDE EL CARRITO ('remove') ---
    elseif ($action === 'remove') {
        // CRÍTICO: Usar el hash como clave
        if ($item_hash && isset($_SESSION['carrito'][$item_hash])) {
            unset($_SESSION['carrito'][$item_hash]);
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
        // Nota: El subtotal individual del ítem se recalcula dentro de la función de total.
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