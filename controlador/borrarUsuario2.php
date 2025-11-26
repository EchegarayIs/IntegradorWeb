<?php
require_once '../modelo/MUsuario.php';

// Detectar si es petición AJAX (fetch)
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (!empty($_POST['idUsuario'])) {

    $usuarioModel = new MUsuario();
    $idUsuario = $_POST['idUsuario'];

    $resultado = $usuarioModel->borrarUsuario2($idUsuario);

    if ($isAjax) {
        // Si es AJAX → devolver JSON
        header('Content-Type: application/json');
        echo json_encode([
            "success" => $resultado === true,
            "error" => $resultado === true ? null : "Error al eliminar el usuario"
        ]);
        exit;
    }

    // Si no es AJAX → alert tradicional
    if ($resultado === true) {
        echo "<script>alert('Usuario eliminado correctamente'); window.location.href='../vista/admin.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario'); window.location.href='../vista/admin.php';</script>";
    }

} else {

    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "error" => "ID de usuario no recibido"]);
        exit;
    }

    echo "<script>alert('ID de usuario no recibido'); window.location.href='../vista/admin.php';</script>";
}


