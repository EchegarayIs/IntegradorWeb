<?php
require_once "../modelo/MPedido.php";

try {
    $pedidoModel = new MPedido();
    $pedidosTerminados = $pedidoModel->pedidosTerminados(); // estado = 3

    if ($pedidosTerminados && count($pedidosTerminados) > 0) {
        echo "
        <div class='pedidos-table-wrapper'>
            <h4 class='table-title finished-title'>Pedidos terminados</h4>
            <div class='table-scroll-area' id='pedidos-terminados'>
                <table class='pedidos-table'>
                    <thead>
                        <tr>
                            <th>No. de pedido</th>
                            <th>Fecha del pedido</th>
                            <th>Turno</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
        ";

        foreach ($pedidosTerminados as $pedido) {
            $fecha = date("d/m/Y", strtotime($pedido["fechaPedido"]));
            echo "
                <tr data-id='{$pedido['idPedido']}'>
                    <td>{$pedido['idPedido']}</td>
                    <td>{$fecha}</td>
                    <td>{$pedido['usuario_idUsuario']}</td>
                    <td><span class='status finished'>Terminado</span></td>
                </tr>
            ";
        }

        echo "
                    </tbody>
                </table>
            </div>
        </div>
        ";

    } else {
        echo "<p>No hay pedidos terminados actualmente.</p>";
    }

} catch (Exception $e) {
    echo "<p>Error al cargar pedidos terminados: " . $e->getMessage() . "</p>";
}
?>
