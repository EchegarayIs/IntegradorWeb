<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../modelo/MProducto.php";

// Validar sesión activa
if (!isset($_SESSION["idUsuario"])) {
    echo "<p>Debe iniciar sesión para ver los productos.</p>";
    exit;
}

try {
    $productoModel = new MProducto();
    $bebidas = $productoModel->listarBebidas(); // Método del modelo

    if ($bebidas && count($bebidas) > 0) {
        foreach ($bebidas as $producto) {

            // ✅ Validar ruta de imagen
            if (!empty($producto["imagen"]) && file_exists($producto["imagen"])) {
                $imagen = $producto["imagen"];
            } else {
                $imagen = "../assets/css/agua.png"; // Imagen por defecto
            }

            // ✅ Estructura del producto con data-id (necesario para editar)
            echo "
            <div class='product-item-card' 
                 data-id='{$producto['idProductos']}' 
                 data-product-type='bebidas'>

                <img src='{$imagen}' alt='{$producto['nombre']}' class='product-image'>

                <div class='product-info'>
                    <span class='product-name'>{$producto['nombre']}</span>
                    <span class='product-price'>$" . number_format($producto['precio'], 2) . "</span>
                </div>

                <div class='product-actions'>
                    <!-- Botón de editar (el script lo maneja por delegación) -->
                    <button class='action-button edit-button'>
                        <img src='../assets/css/editar.png' alt='Editar'>
                    </button>

                    <!-- Botón de eliminar -->
                    <button class='action-button delete-button' onclick='eliminarProducto({$producto['idProductos']})'>
                        <img src='../assets/css/botebasuranaranja.png' alt='Eliminar'>
                    </button>
                </div>
            </div>
            ";
        }
    } else {
        echo "<p>No hay productos registrados en la categoría bebidas.</p>";
    }
} catch (Exception $e) {
    echo "<p>Error al cargar las bebidas: " . $e->getMessage() . "</p>";
}
?>


