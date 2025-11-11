<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../modelo/MProducto.php";

if (!isset($_SESSION["idUsuario"])) {
    echo "<p>Debe iniciar sesión para ver los productos.</p>";
    exit;
}

try {
    $productoModel = new MProducto();
    $tacos = $productoModel->listarTacos(); // Método que trae productos tipo tacos

    if ($tacos && count($tacos) > 0) {
        foreach ($tacos as $producto) {
            // Validar si hay imagen en la BD, o usar una por defecto
            if (!empty($producto["imagen"]) && file_exists($producto["imagen"])) {
                $imagen = $producto["imagen"];
            } else {
                $imagen = "../assets/css/Captura de pantalla 2025-11-07 001614.png";
            }

            // Generar HTML del producto
            echo "
            <div class='product-item-card' data-product-type='tacos' data-product-id='{$producto['idProductos']}'>
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
        echo "<p>No hay productos registrados en la categoría tacos.</p>";
    }
} catch (Exception $e) {
    echo "<p>Error al cargar los productos: " . $e->getMessage() . "</p>";
}
?>

