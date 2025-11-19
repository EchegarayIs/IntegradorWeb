<?php
require_once "../modelo/MPedido.php";

try {
    $pedidoModel = new MPedido();
    $pedidosProceso = $pedidoModel->pedidosProceso();

    if ($pedidosProceso && count($pedidosProceso) > 0) {
        echo "
        <div class='pedidos-table-wrapper'>
            <h4 class='table-title in-progress-title'>Pedidos en proceso</h4>
            <div class='table-scroll-area' id='pedidos-proceso'>
                <table class='pedidos-table'>
                    <thead>
                        <tr>
                            <th></th>
                            <th>No. de pedido</th>
                            <th>Fecha del pedido</th>
                            <th>Turno</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
        ";

        foreach ($pedidosProceso as $pedido) {
            $fecha = date("d/m/Y", strtotime($pedido["fechaPedido"]));
            echo "
                <tr data-id='{$pedido['idPedido']}'>
                    <td><input type='checkbox' class='pedido-checkbox' value='{$pedido['idPedido']}'></td>
                    <td>{$pedido['idPedido']}</td>
                    <td>{$fecha}</td>
                    <td>{$pedido['usuario_idUsuario']}</td>
                    <td><span class='status in-progress'>En proceso</span></td>
                </tr>
            ";
        }

        echo "
                    </tbody>
                </table>
            </div>

            <button class='change-status-button' id='btnCambiarEstadoProceso'>
                Cambiar estado
            </button>
        </div>
        ";
    } else {
        echo "<p>No hay pedidos en proceso actualmente.</p>";
    }

} catch (Exception $e) {
    echo "<p>Error al cargar pedidos en proceso: " . $e->getMessage() . "</p>";
}
?>
