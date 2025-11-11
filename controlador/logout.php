<?php
// Paso 1: Iniciar la sesión (CRÍTICO para acceder a los datos de sesión y destruirla)
session_start();

// Paso 2: Destruir TODAS las variables de sesión del array $_SESSION
$_SESSION = array();

// Paso 3: Destruir la cookie de sesión (RECOMENDADO)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Paso 4: Finalmente, destruir la sesión en el servidor
session_destroy();

// Paso 5: Redirigir al usuario al login (o inicio)
// Asegúrate que esta ruta es correcta (ej. si estás en controlador, necesitas ir a vista)
header("Location: ../vista/login.php"); 
exit;
?>