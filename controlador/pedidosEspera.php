<?php

require_once "../modelo/MPedido.php";

try {
    if (!isset($_SESSION['idUsuario'])) {
        echo "<p class='error-message'>Debe iniciar sesión para ver los pedidos en espera.</p>";
        exit;
    }

    $pedidoModel = new MPedido();
    $pedidos = $pedidoModel->pedidosEspera(); // Solo pedidos con estado = 1 (en espera)

    if ($pedidos && count($pedidos) > 0) {
        echo "
        <div class='pedidos-table-wrapper'>
            <h4 class='table-title pending-title'>Pedidos en espera</h4>
            <div class='table-scroll-area' id='pedidos-espera'>
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

        foreach ($pedidos as $pedido) {
            $estadoTexto = "En espera";
            $fecha = date("d/m/Y", strtotime($pedido["fechaPedido"]));

            echo "
                <tr data-id='{$pedido['idPedido']}'>
                    <td><input type='checkbox' class='pedido-checkbox' value='{$pedido['idPedido']}'></td>
                    <td>{$pedido['idPedido']}</td>
                    <td>{$fecha}</td>
                    <td>{$pedido['usuario_idUsuario']}</td>
                    <td><span class='status pending' data-status='pending'>{$estadoTexto}</span></td>
                </tr>
            ";
        }

        echo "
                    </tbody>
                </table>
            </div>
            <button class='change-status-button' id='btnCambiarEstado'>Cambiar estado</button>
        </div>
        ";
    } else {
        echo "<p>No hay pedidos en espera actualmente.</p>";
    }

} catch (Exception $e) {
    echo "<p>Error al cargar los pedidos: " . $e->getMessage() . "</p>";
}
?>
