<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../modelo/MProducto.php";

// Verificar sesión
if (!isset($_SESSION["idUsuario"])) {
    echo "<p>Debe iniciar sesión para ver los productos.</p>";
    exit;
}

try {
    $productoModel = new MProducto();
    $bebidas = $productoModel->listarBebidas(); // Método que trae productos tipo bebidas

    if ($bebidas && count($bebidas) > 0) {
        foreach ($bebidas as $producto) {
            // ✅ Verificar si la imagen existe en el servidor
            if (!empty($producto["imagen"]) && file_exists($producto["imagen"])) {
                $imagen = $producto["imagen"];
            } else {
                // Imagen por defecto si no se encuentra la ruta
                $imagen = "../assets/css/agua.png";
            }

            // ✅ Generar el HTML del producto
            echo "
            <div class='product-item-card' data-product-type='bebidas' data-product-id='{$producto['idProductos']}'>
                <img src='{$imagen}' alt='{$producto['nombre']}' class='product-image'>
                <div class='product-info'>
                    <span class='product-name'>{$producto['nombre']}</span>
                    <span class='product-price'>$" . number_format($producto['precio'], 2) . "</span>
                </div>
                <div class='product-actions'>
                    <button class='action-button edit-button' onclick='editarProducto({$producto['idProductos']})'>
                        <img src='../assets/css/editar.png' alt='Editar'>
                    </button>
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

