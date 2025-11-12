<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../modelo/MProducto.php";

if (!isset($_GET['idProductos'])) {
    echo json_encode(["error" => "No se recibió el parámetro idProductos"]);
    exit;
}

$idProductos = intval($_GET['idProductos']);
$productoModel = new MProducto();

try {
    $producto = $productoModel->buscarPorId($idProductos);

    if ($producto && isset($producto['idProductos'])) {
        echo json_encode($producto, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(["error" => "Producto no encontrado"]);
    }

} catch (Throwable $e) {
    echo json_encode(["error" => "Error interno: " . $e->getMessage()]);
}

