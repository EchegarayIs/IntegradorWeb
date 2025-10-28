<?php
require_once '../modelo/Usuario.php';

// Validar que vienen los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre     = $_POST['nombre'] ?? '';
    $apellidos  = $_POST['apellidos'] ?? '';
    $fechaNac   = $_POST['fechaNacimiento'] ?? '';
    $direccion  = $_POST['direccion'] ?? '';
    $genero     = $_POST['genero'] ?? '';
    $correo     = $_POST['correo'] ?? '';
    $password   = $_POST['password'] ?? '';
    $confirmar  = $_POST['confirmar'] ?? '';

    if ($password !== $confirmar) {
        die("Las contraseñas no coinciden.");
    }

    // Aquí puedes agregar validaciones adicionales
    $usuario = new Usuario();
    $resultado = $usuario->registrarUsuario($nombre, $apellidos, $fechaNac, $direccion, $genero, $correo, $password);

    if ($resultado) {
        echo "<script>alert('Usuario registrado exitosamente'); window.location.href='../vista/login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar usuario'); window.location.href='../vista/registrar.php';</script>";
    }
}
?>
