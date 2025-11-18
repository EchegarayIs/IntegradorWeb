<?php
require_once "../modelo/MPedido.php";

try {
    // Verificamos si se recibió el id del pedido por POST
    if (!isset($_POST['idPedido']) || empty($_POST['idPedido'])) {
        echo "<script>alert('No se recibió el ID del pedido.'); window.history.back();</script>";
        exit;
    }

    $idPedido = intval($_POST['idPedido']);

    // Instancia del modelo
    $pedidoModel = new MPedido();
    $resultado = $pedidoModel->actualizarEstadoPedido($idPedido);

    if ($resultado === true) {
        echo "<script>alert('Estado del pedido actualizado correctamente.'); window.location.href='../vista/admin.php';</script>";
    } else {
        echo "<script>alert('Error: $resultado'); window.history.back();</script>";
    }

} catch (Exception $e) {
    echo "<script>alert('Error inesperado: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>
