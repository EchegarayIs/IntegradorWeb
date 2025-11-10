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
    $passwor   = $_POST['passwor'] ?? '';
    $confirmar  = $_POST['confirmar'] ?? '';

    if ($passwor !== $confirmar) {
        die("Las contraseñas no coinciden.");
    }

    // Aquí puedes agregar validaciones adicionales
    $usuario = new Usuario();
    $resultado = $usuario->registrarUsuario($nombre, $apellidos, $fechaNac, $direccion, $genero, $correo, $passwor);

    if ($resultado) {
        echo "<script>alert('Usuario registrado exitosamente'); window.location.href='../vista/login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar usuario' . ); window.location.href='../vista/register.php';</script>";
        echo "<pre>$resultado</pre>";
    }
}
?>
