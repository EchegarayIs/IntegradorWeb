<?php
session_start();
require_once "../modelo/Usuario.php";

// Validar sesión activa (si quieres que solo admin registre)
if (!isset($_SESSION["idUsuario"])) {
    echo "<script>
            alert('Debe iniciar sesión');
            window.location.href='../vista/login.php';
          </script>";
    exit;
}

try {
    // Verificar que los campos existan
    if (
        empty($_POST['nombre']) || empty($_POST['apellidos']) || empty($_POST['fechaNac']) ||
        empty($_POST['direccion']) || empty($_POST['genero']) || empty($_POST['correo']) ||
        empty($_POST['passwor'])
    ) {
        echo "<script>
                alert('Todos los campos son obligatorios');
                window.location.href='../vista/admin.php';
              </script>";
        exit;
    }

    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $fechaNac = $_POST["fechaNac"];
    $direccion = $_POST["direccion"];
    $genero = $_POST["genero"];
    $correo = $_POST["correo"];
    $passwor = $_POST["passwor"];

    // Crear instancia del modelo
    $usuarioModel = new Usuario();

    // Registrar personal con rol = 2
    $resultado = $usuarioModel->registrarUsuario2(
        $nombre,
        $apellidos,
        $fechaNac,
        $direccion,
        $genero,
        $correo,
        $passwor
    );

    // Mensajes estilo EXACTO del ejemplo que pediste
    if ($resultado === true) {
        echo "<script>
                alert('Personal registrado correctamente');
                window.location.href='../vista/admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al registrar el personal');
                window.location.href='../vista/admin.php';
              </script>";
    }

} catch (Exception $e) {
    // Error interno
    $error = addslashes($e->getMessage());
    echo "<script>
            alert('Ocurrió un error: $error');
            window.location.href='../vista/admin.php';
          </script>";
}
?>
