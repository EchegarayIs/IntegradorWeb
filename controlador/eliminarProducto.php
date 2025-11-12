<?php
require_once "../modelo/MProducto.php";

header('Content-Type: application/json');

try {
    if (!isset($_POST['idProductos'])) {
        echo json_encode(["success" => false, "error" => "ID del producto no proporcionado"]);
        exit;
    }

    $idProductos = intval($_POST['idProductos']);
    $productoModel = new MProducto();

    $resultado = $productoModel->eliminarProducto($idProductos);

    if ($resultado) {
        echo json_encode(["success" => true, "message" => "Producto eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "error" => "No se pudo eliminar el producto"]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => "Error: " . $e->getMessage()]);
}
?>
