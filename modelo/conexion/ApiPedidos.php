<?php
// modelo/conexion/ApiPedidos.php

// Iniciar sesión (CRÍTICO para acceder a $_SESSION['carrito'])
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../MPedido.php'); 

// Inicializar la respuesta
$response = ['success' => false, 'message' => 'Petición no procesada.'];

// Asegurar que la petición es POST y que tiene una acción definida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    switch ($_POST['action']) {        
        case 'process_order':
            
            // 1. Validar parámetros y carrito
            if (!isset($_POST['total']) || !isset($_POST['metodo_pago'])) {
                 $response['message'] = 'Faltan parámetros (total o metodo_pago) en la petición.';
                 break;
            }

            if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
                $response['message'] = 'El carrito de la sesión está vacío o no existe.';
                break;
            }

            $total = (float)$_POST['total'];
            $metodoPago = $_POST['metodo_pago'];
            
            //VALOR TEMPORAL SOLICITADO: Usar 10 para el ID del usuario si no hay sesion.
            $idUsuario = $_SESSION['idUsuario'] ?? 10; 
            
            $carrito = $_SESSION['carrito'];
            
            try {
                $pedidoModel = new MPedido();
                
                // Intentar registrar el pedido (llamando a la función corregida)
                $idPedido = $pedidoModel->registrarPedido($idUsuario, $total, $metodoPago, $carrito);

                if ($idPedido !== false) {
                    //Limpiar el carrito de la sesión
                    unset($_SESSION['carrito']); 
                    
                    $response['success'] = true;
                    $response['message'] = 'Pedido registrado con éxito.';
                    $response['order_id'] = $idPedido;
                } else {
                    // Este caso no debería ejecutarse si el catch de MPedido lanza la excepción
                    $response['message'] = 'Error al registrar el pedido en la base de datos (Modelo devolvió FALSE).';
                }

            } catch (Exception $e) {
                //Capturamos la excepción real lanzada desde MPedido.php con el error SQL
                $response['success'] = false;
                $response['message'] = 'Error de Base de Datos: ' . $e->getMessage(); 
            }

        break;
        
        default:
            $response['message'] = 'Acción de pedido no válida.';
            break;
    }
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>