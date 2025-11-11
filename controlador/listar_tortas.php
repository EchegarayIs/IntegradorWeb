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
    $tortas = $productoModel->listarTortas(); // Método del modelo

    if ($tortas && count($tortas) > 0) {
        foreach ($tortas as $producto) {
            // ✅ Validar ruta de imagen
            if (!empty($producto["imagen"]) && file_exists($producto["imagen"])) {
                $imagen = $producto["imagen"];
            } else {
                $imagen = "../assets/css/torta_default.png"; // Imagen por defecto
            }

            // ✅ Estructura HTML del producto
            echo "
            <div class='product-item-card' data-product-type='tortas' data-product-id='{$producto['idProductos']}'>
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
        echo "<p>No hay productos registrados en la categoría tortas.</p>";
    }
} catch (Exception $e) {
    echo "<p>Error al cargar las tortas: " . $e->getMessage() . "</p>";
}
?>

