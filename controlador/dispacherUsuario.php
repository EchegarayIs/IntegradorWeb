<?php
session_start();
require_once "../modelo/MUsuario.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    $model = new MUsuario();
    $resultado = $model->validarLogin($usuario, $password);

    if ($resultado) {
        if ($resultado["Roles_idRol"] == 1) { # Para usuarios comunes
            // Guardar sesión
            $_SESSION["idUsuario"] = $resultado["idUsuario"];
            $_SESSION["nombre"] = $resultado["nombre"];
            $_SESSION["rol"] = $resultado["Roles_idRol"];

            header("Location: ../vista/index.php");
            
        }elseif ($resultado["Roles_idRol"] == 2) { #Para administradores
            // Guardar sesión
            $_SESSION["idUsuario"] = $resultado["idUsuario"];
            $_SESSION["nombre"] = $resultado["nombre"];
            $_SESSION["rol"] = $resultado["Roles_idRol"];

            header("Location: ../vista/indexA.php");
            
        } else {
            echo "<script>alert('Acceso denegado. Solo los usuarios con rol 1 pueden entrar.'); window.location.href='../vista/login.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../vista/login.php';</script>";
    }
}
?>
