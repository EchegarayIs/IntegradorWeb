<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../modelo/MProducto.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

$idProductos = $_POST['idProductos'] ?? null;
$precio = $_POST['precio'] ?? null;

if (!$idProductos || $precio === null) {
    echo json_encode(["error" => "Faltan datos obligatorios"]);
    exit;
}

try {
    $productoModel = new MProducto();
    $resultado = $productoModel->editarPrecio($idProductos, $precio);

    if ($resultado) {
        echo json_encode(["success" => true, "message" => "Precio actualizado correctamente"]);
    } else {
        echo json_encode(["error" => "No se pudo actualizar el precio"]);
    }

} catch (Throwable $e) {
    echo json_encode(["error" => "Error interno: " . $e->getMessage()]);
}