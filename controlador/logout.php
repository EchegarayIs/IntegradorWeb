<?php
// Iniciar la sesión (CRÍTICO para acceder a los datos de sesión y destruirla)
session_start();

// Destruir TODAS las variables de sesión del array $_SESSION
$_SESSION = array();

// Destruir la cookie de sesión (RECOMENDADO)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión en el servidor
session_destroy();

// Redirigir al usuario al login (o inicio)
header("Location: ../vista/login.php"); 
exit;
?>