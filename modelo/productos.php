<?php

class productos {
    function consultarProductos() {
        $conexion = new Conexion();
        $cnx = $conexion->conectar();

        // Consulta para obtener los productos
        $stmt = $cnx->prepare("CALL dbintegrador.sp_ConsultarProductos()");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $productos = $stmt->fetchAll();

        // Cerrar la conexión
        $conexion->cerrarConexion();

        // Retornar los productos obtenidos
        return $productos;

    }   
}

?>