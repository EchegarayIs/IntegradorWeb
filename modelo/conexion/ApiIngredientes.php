<?php

    /**
     * Autor: Mariel Hernández Reyes
     * Fecha: 27/10/25
     * Descripción: Gestiona las peticiones a la API para Ingredientes
     */
require_once 'conection.php';
require_once 'ADIngredientes.php';

function verificadoDeParametros($params){
    $available = true;
    $missingparams = "";

    // si se dispone de todos los parametros
    foreach ($params as $param) {
        if(!isset($_POST[$param]) || strlen($_POST[$param]) <= 0){
            $available = false;
            $missingparams = $missingparams . ", " . $param;
        }
    }

    //si faltan parametros
    if(!$available){
        $response = array();
        $response['error'] = true;
        $response['aviso'] = 'Parametro' . substr($missingparams, 1, strlen($missingparams)) . ' vacio';

        echo json_encode($response);
        die();
    }
}

$response = array();
    
if(isset($_GET['api'])){

    switch ($_GET['api']) {        
        case 'listarTacos':
            $db = new ADIngredientes();
            $result = $db->listarTacos();
            if($result){
            $response['error'] = false;
            $response['aviso'] = 'Solicitud completada correctamente';
            $response['contenido'] = $result;
            }else{
                $response['error'] = true;
                $response['aviso'] = 'Error al obtener la lista de ingredientes';
            }
        break;

        case 'listarTortas':
            $db = new ADIngredientes();
            $result = $db->listarTortas();
            if($result){
            $response['error'] = false;
            $response['aviso'] = 'Solicitud completada correctamente';
            $response['contenido'] = $result;
            }else{
                $response['error'] = true;
                $response['aviso'] = 'Error al obtener la lista de ingredientes';
            }
        break;

        case 'listarBebidas':
            $db = new ADIngredientes();
            $result = $db->listarBebidas();
            if($result){
            $response['error'] = false;
            $response['aviso'] = 'Solicitud completada correctamente';
            $response['contenido'] = $result;
            }else{
                $response['error'] = true;
                $response['aviso'] = 'Error al obtener la lista de ingredientes';
            }
        break;

        case 'guardar':
            $db = new ADIngredientes();
            $result = $db->guardar($_POST['nombre']);
            if($result){
                $response['error'] = false;
                $response['aviso'] = 'Solicitud completada correctamente';
                $response['contenido'] = '';
            }else{
                $response['error'] = true;
                $response['aviso'] = 'Error al guardar el ingrediente';
            }
        break;
        case 'editar':
            $db = new ADIngredientes();
            $result = $db->editar($_POST['idIngrediente'],$_POST['nombre']);
            if($result){
                $response['error'] = false;
                $response['aviso'] = 'Solicitud completada correctamente';
                $response['contenido'] = '';
            }else{
                $response['error'] = true;
                $response['aviso'] = 'Error al editar el ingrediente';
            }
        break;
        case 'eliminar':
            $db = new ADIngredientes();
            $result = $db->eliminar($_POST['idIngrediente']);
            if($result){
                $response['error'] = false;
                $response['aviso'] = 'Solicitud completada correctamente';
                $response['contenido'] = '';
            }else{
                $response['error'] = true;
                $response['aviso'] = 'Error al eliminar el ingrediente';
            }
    }
}else{
    $response['error'] = true;
    $response['aviso'] = 'Llamada API invalida';
}

echo json_encode($response);
?>