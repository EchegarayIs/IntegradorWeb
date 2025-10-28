<?php
require_once "conection.php";

class ADProductos {

     public static function listar() {
        $stmt = conection::conectar()->prepare("CALL dbintegrador.sp_ConsultarProductos()");
        $stmt->execute();

        $lista = array();

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $modelo = array();
            $modelo["idProductos"] = $fila["idProductos"];
            $modelo["nombre"]      = $fila["nombre"];
            $modelo["precio"]      = $fila["precio"];
            $modelo["imagen"]      = $fila["imagen"];
            $modelo["estado"]      = $fila["estado"];
            $modelo["categoria"]   = $fila["categoria"];

            array_push($lista, $modelo);
        }

        return $lista;
    }

}
?>