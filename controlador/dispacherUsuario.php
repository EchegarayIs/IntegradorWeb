<?php
session_start();    
require_once "../modelo/MUsuario.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $passwor = trim($_POST["passwor"]);

    $model = new MUsuario();
    $resultado = $model->validarLogin($usuario, $passwor);

    if ($resultado) {
        // Guardar todos los datos del usuario en la sesión
        $_SESSION["idUsuario"] = $resultado["idUsuario"];
        $_SESSION["nombre"] = $resultado["nombre"];
        $_SESSION["apellidos"] = $resultado["apellidos"];
        $_SESSION["fechaNac"] = $resultado["fechaNac"];
        $_SESSION["direccion"] = $resultado["direccion"];
        $_SESSION["genero"] = $resultado["genero"];
        $_SESSION["correo"] = $resultado["correo"];
        $_SESSION["rol"] = $resultado["Roles_idRol"];
        $_SESSION["passwor"] = $resultado["passwor"];
        $_SESSION["estado"] = $resultado["estado"];

        // Redirigir según el rol
        if ($resultado["Roles_idRol"] == 1) {
            header("Location: ../vista/inicio.php");
        } elseif ($resultado["Roles_idRol"] == 2) {
            header("Location: ../vista/indexA.php");
        } else {
            echo "<script>alert('Acceso denegado.'); window.location.href='../vista/login.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../vista/login.php';</script>";
    }
}
?>
