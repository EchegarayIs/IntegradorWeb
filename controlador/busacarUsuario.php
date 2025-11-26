<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../modelo/MUsuario.php";

// Validar parámetro
if (!isset($_GET['idUsuario'])) {
    echo json_encode(["error" => "No se recibió el parámetro idUsuario"]);
    exit;
}

$idUsuario = intval($_GET['idUsuario']);
$usuarioModel = new MUsuario();

try {

    $usuario = $usuarioModel->buscarUsuarioPorId($idUsuario);

    if ($usuario && isset($usuario['idUsuario'])) {
        echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(["error" => "Usuario no encontrado"]);
    }

} catch (Throwable $e) {
    echo json_encode(["error" => "Error interno"]);
}
?>


