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
    $tacos = $productoModel->listarTacos(); // Método del modelo

    if ($tacos && count($tacos) > 0) {
        foreach ($tacos as $producto) {
            if (!empty($producto["imagen"]) && file_exists($producto["imagen"])) {
                $imagen = $producto["imagen"];
            } else {
                $imagen = "../assets/css/Captura de pantalla 2025-11-07 001614.png"; // Imagen por defecto
            }

            echo "
            <div class='product-item-card'
                 data-id='{$producto['idProductos']}'
                 data-product-type='tacos'>

                <img src='{$imagen}' alt='{$producto['nombre']}' class='product-image'>

                <div class='product-info'>
                    <span class='product-name'>{$producto['nombre']}</span>
                    <span class='product-price'>$" . number_format($producto['precio'], 2) . "</span>
                </div>

                <div class='product-actions'>
                    <!-- Botón editar: manejado por delegación en el JS -->
                    <button class='action-button edit-button'>
                        <img src='../assets/css/editar.png' alt='Editar'>
                    </button>

                    <!-- Botón eliminar (mantiene su onclick) -->
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



