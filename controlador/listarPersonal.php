<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../modelo/MUsuario.php";

// Validar sesión activa
if (!isset($_SESSION["idUsuario"])) {
    echo "<p>Debe iniciar sesión para ver el personal.</p>";
    exit;
}

try {
    $usuarioModel = new MUsuario();
    $personal = $usuarioModel->listarUsuariosRol2(); // SOLO rol = 2

    if ($personal && count($personal) > 0) {



        foreach ($personal as $persona) {

            $imagen = "../assets/css/personal.png";

            echo "
                <div class='person-item-card' data-id='{$persona['idUsuario']}'>

                    <img src='{$imagen}' 
                         alt='{$persona['nombre']} {$persona['apellidos']}' 
                         class='person-image'>

                    <div class='person-info'>
                        <span class='person-name'>{$persona['nombre']} {$persona['apellidos']}</span>
                        <span class='person-role'>Empleado</span>
                    </div>

                    <div class='person-actions'>
                        <button class='action-button edit-person-button' 
                                data-id='{$persona['idUsuario']}'>
                            <img src='../assets/css/editar.png' alt='Editar'>
                        </button>

                        <button class='action-button delete-person-button' 
                                data-id='{$persona['idUsuario']}'>
                            <img src='../assets/css/botebasuranaranja.png' alt='Eliminar'>
                        </button>
                    </div>

                </div>
            ";
        }

    } else {
        echo "<p>No hay personal registrado.</p>";
    }

} catch (Exception $e) {
    echo "<p>Error al cargar el personal: " . $e->getMessage() . "</p>";
}
?>

