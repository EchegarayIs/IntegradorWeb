<?php
session_start();
require_once "../modelo/MUsuario.php";

try {
    // Validar sesión
    if (!isset($_SESSION['idUsuario'])) {
        echo json_encode(["success" => false, "mensaje" => "Sesión no válida."]);
        exit;
    }

    // Validar datos del formulario
    $idUsuario = $_SESSION['idUsuario'];
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $fechaNac = $_POST['fechaNac'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $passwor = $_POST['passwor'] ?? '';
    $confirmar = $_POST['confirm_password'] ?? '';

    if ($passwor !== $confirmar) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.location.href='../vista/mesero.php';</script>";
        exit;
    }

    // Actualizar usuario
    $usuarioModel = new MUsuario();
    $resultado = $usuarioModel->editarUsuario($idUsuario, $nombre, $apellidos, $fechaNac, $direccion, $genero, $correo, $passwor);

    if ($resultado) {
        // Actualiza los datos de sesión
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellidos'] = $apellidos;
        $_SESSION['fechaNac'] = $fechaNac;
        $_SESSION['direccion'] = $direccion;
        $_SESSION['genero'] = $genero;
        $_SESSION['correo'] = $correo;
        $_SESSION['passwor'] = $passwor;

        echo "<script>alert('Editado con exito.'); window.location.href='../vista/mesero.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario.'); window.location.href='../vista/mesero.php';</script>";
    }

} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='../vista/mesero.php';</script>";
}
?>