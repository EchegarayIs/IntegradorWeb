<?php

session_unset();     // Borra todas las variables de sesión
session_destroy();   // Destruye la sesión completamente

header("Location: ../index.php"); // Redirige al usuario a la página de inicio u otra página deseada
exit();

?>