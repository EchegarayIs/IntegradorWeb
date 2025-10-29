<?php
header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once "conection.php";
require_once "ADPedidos.php";

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