<?php
require_once "conection.php";

class ADProductos {

     public static function insertarPedido() {
        $stmt = conection::conectar()->prepare("CALL dbintegrador.sp_insertarPedido()");
        $stmt->execute();

        $lista = array();

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $modelo = array();
            $modelo["idPedido"] = $fila["idPedido"];
            $modelo["monto"]      = $fila["monto"];
            $modelo["fechaPedido"]      = $fila["fechaPedido"];
            $modelo["usuario_idUsuario"]      = $fila["usuario_idUsuario"];
            $modelo["estado"]      = $fila["estado"];
            $modelo["pedidos_idPedidos"]   = $fila["pedios_idPedidos"];

            array_push($lista, $modelo);
        }

        return $lista;
    }

}
?>