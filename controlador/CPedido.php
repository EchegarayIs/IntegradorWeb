<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../modelo/MPedido.php";

if (!isset($_SESSION["idUsuario"])) {
    echo "<p>Debe iniciar sesión para ver sus pedidos.</p>";
    exit;
}

$idUsuario = $_SESSION["idUsuario"];
$model = new MPedido();
$pedidos = $model->listarPedidosPorUsuario($idUsuario);

if ($pedidos && count($pedidos) > 0) {
    foreach ($pedidos as $pedido) {
        // Determinar el estado visual
        switch ($pedido["estado"]) {
            case 1:
                $estadoTexto = "En espera";
                $estadoClase = "pending";
                break;
            case 2:
                $estadoTexto = "En proceso";
                $estadoClase = "in-progress";
                break;
            case 3:
                $estadoTexto = "Terminado";
                $estadoClase = "finished";
                break;
            default:
                $estadoTexto = "Desconocido";
                $estadoClase = "";
        }

        // Mostrar pedido
        echo "
        <div class='order-card'>
            <img src='../assets/css/logosolotaco.png' alt='Taco' class='order-image'>
            <div class='order-details'>
                <span class='order-id'>Pedido #{$pedido['idPedido']}</span>
                <span class='order-date'>".date('d \d\e F, Y', strtotime($pedido['fechaPedido']))."</span>
                <span class='order-total'>Total: $".number_format($pedido['monto'], 2)."</span>
            </div>
            <div class='order-status {$estadoClase}'>{$estadoTexto}</div>
        </div>
        ";
    }
} else {
    echo "<p>No tienes pedidos registrados.</p>";
}
?>

