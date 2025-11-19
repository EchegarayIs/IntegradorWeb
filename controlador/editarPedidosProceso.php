<?php
require_once "../modelo/MPedido.php";

try {
    // Validar idPedido recibido
    if (!isset($_POST['idPedido']) || empty($_POST['idPedido'])) {
        echo "<script>alert('No se recibió el ID del pedido.'); window.history.back();</script>";
        exit;
    }

    $idPedido = intval($_POST['idPedido']);

    // Modelo
    $pedidoModel = new MPedido();
    $resultado = $pedidoModel->actualizarEstadoPedido($idPedido);

    if ($resultado === true) {
        echo "<script>alert('El pedido pasó de EN PROCESO a TERMINADO.'); window.location.href='../vista/admin.php';</script>";
    } else {
        echo "<script>alert('Error: $resultado'); window.history.back();</script>";
    }

} catch (Exception $e) {
    echo "<script>alert('Error inesperado: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>
