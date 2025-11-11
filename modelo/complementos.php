<?php

class complementos {
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

    public static function listarTacos(){

        $conexion = new Conexion();
        $cnx = $conexion->conectar();

        // Consulta para obtener los complementos de bebidas
        $stmt = $cnx->prepare("SELECT idIngrediente, nombre FROM ingredientes WHERE categoria = 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $tacos = $stmt->fetchAll();

        // Cerrar la conexión
        $conexion->cerrarConexion();

        // Retornar los complementos de bebidas obtenidos
        return $tacos;
    }

    public static function listarTortas(){
        $conexion = new Conexion();
        $cnx = $conexion->conectar();

        // Consulta para obtener los complementos de bebidas
        $stmt = $cnx->prepare("SELECT idIngrediente, nombre FROM ingredientes WHERE categoria = 3");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $tortas = $stmt->fetchAll();

        // Cerrar la conexión
        $conexion->cerrarConexion();

        // Retornar los complementos de bebidas obtenidos
        return $tortas;
    }

    public static function listarBebidas(){
        $conexion = new Conexion();
        $cnx = $conexion->conectar();

        // Consulta para obtener los complementos de bebidas
        $stmt = $cnx->prepare("SELECT idIngrediente, nombre FROM ingredientes WHERE categoria = 2");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $bebidas = $stmt->fetchAll();

        // Cerrar la conexión
        $conexion->cerrarConexion();

        // Retornar los complementos de bebidas obtenidos
        return $bebidas;
    }

    public static function guardar($nombre){
        $result = conection::conectar()->prepare("INSERT INTO `ingredientes` (`nombre`, `categoria`) VALUES (:nombre, :categoria)");
        
        $result->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $result->bindParam(":categoria", $categoria, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function editar($idIngrediente,$nombre){
        $result = conection::conectar()->prepare("UPDATE ingredientes SET 
                                                nombre = :nombre,
                                                categoria = :categoria
                                                WHERE idIngrediente = :idIngrediente");
        
        $result->bindParam(":idIngrediente", $idIngrediente, PDO::PARAM_INT);
        $result->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $result->bindParam(":categoria", $categoria, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function eliminar($idIngrediente){
        $result = conection::conectar()->prepare("DELETE FROM ingredientes WHERE idIngrediente = :idIngrediente");
        
        $result->bindColumn(":idIngrediente", $idIngrediente, PDO::PARAM_INT);

        return $result->execute();
    }


}

?>