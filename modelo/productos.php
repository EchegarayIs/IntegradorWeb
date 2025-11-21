<?php

class productos {
    function consultarProductos() {
        $conexion = new Conexion();
        $cnx = $conexion->conectar();

        // Consulta para obtener los productos
        $stmt = $cnx->prepare("CALL sp_ConsultarProductos()");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $productos = $stmt->fetchAll();

        $conexion->cerrarConexion();

        return $productos;

    }   
}

?>