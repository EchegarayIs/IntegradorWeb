<?php
require_once "conection.php";
require_once "ADProductos.php";

function verificarParametros($params) {
    $available = true;
    $missingparams = "";

    foreach ($params as $param) {
        if (!isset($_POST[$param]) || strlen($_POST[$param]) <= 0) {
            $available = false;
            $missingparams .= ", " . $param;
        }
    }

    if (!$available) {
        $response = array();
        $response['error'] = true;
        $response['aviso'] = 'Parámetro' . substr($missingparams, 1) . ' vacío';
        echo json_encode($response);
        die();
    }
}

$response = array();

if (isset($_GET['api'])) {
    $db = new ADProductos();

    switch ($_GET['api']) {        
        case 'listar':
            $lista = $db->listar();
            $response['error'] = false;
            $response['aviso'] = 'Solicitud completada correctamente';
            $response['contenido'] = $lista;
            break;
        default:
            $response['error'] = true;
            $response['aviso'] = 'Operación no válida';
            break;
    }
} else {
    $response['error'] = true;
    $response['aviso'] = 'No se llamó a la API';
}

echo json_encode($response);

?>