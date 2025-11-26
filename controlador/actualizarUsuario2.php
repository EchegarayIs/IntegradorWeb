<?php
require_once '../modelo/MUsuario.php';

// Detectar si es petición AJAX (fetch)
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (
    !empty($_POST['idUsuario']) &&
    !empty($_POST['nombre2']) &&
    !empty($_POST['apellidos2']) &&
    !empty($_POST['fechaNac2']) &&
    !empty($_POST['direccion2']) &&
    !empty($_POST['genero2']) &&
    !empty($_POST['correo2']) &&
    !empty($_POST['passwor2'])
) {

    $usuarioModel = new MUsuario();

    $resultado = $usuarioModel->actualizarUsuario2(
        $_POST['idUsuario'],
        $_POST['nombre2'],
        $_POST['apellidos2'],
        $_POST['fechaNac2'],
        $_POST['direccion2'],
        $_POST['genero2'],
        $_POST['correo2'],
        $_POST['passwor2']
    );

    // SI ES AJAX → devolver JSON limpio
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(["success" => $resultado === true]);
        exit;
    }

    // SI NO ES AJAX → tus alertas en <script>
    if ($resultado === true) {
        echo "<script>alert('Usuario actualizado correctamente'); window.location.href='../vista/admin.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario'); window.location.href='../vista/admin.php';</script>";
    }

} else {

    // SI ES AJAX → error JSON
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "error" => "Faltan datos"]);
        exit;
    }

    // SI NO ES AJAX → alert tradicional
    echo "<script>alert('Faltan datos para actualizar'); window.location.href='../vista/admin.php';</script>";
}

