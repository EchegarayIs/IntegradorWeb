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

<<<<<<< HEAD
=======
            // Validar ruta de imagen
>>>>>>> 28dd60aa7d3d58080a9d1d4cb63ca65f076b058d
            if (!empty($producto["imagen"]) && file_exists($producto["imagen"])) {
                $imagen = $producto["imagen"];
            } else {
                $imagen = "../assets/css/torta_default.png"; // Imagen por defecto
            }

<<<<<<< HEAD
=======
            // Estructura del producto con data-id (necesario para editar)
>>>>>>> 28dd60aa7d3d58080a9d1d4cb63ca65f076b058d
            echo "
            <div class='product-item-card' 
                 data-id='{$producto['idProductos']}' 
                 data-product-type='tortas'>

                <img src='{$imagen}' alt='{$producto['nombre']}' class='product-image'>

                <div class='product-info'>
                    <span class='product-name'>{$producto['nombre']}</span>
                    <span class='product-price'>$" . number_format($producto['precio'], 2) . "</span>
                </div>

                <div class='product-actions'>
                    <!-- Botón de editar (ya no usa onclick, el script lo maneja por delegación) -->
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
        echo "<p>No hay productos registrados en la categoría tortas.</p>";
    }
} catch (Exception $e) {
    echo "<p>Error al cargar las tortas: " . $e->getMessage() . "</p>";
}
?>


