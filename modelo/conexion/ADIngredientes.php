<?php
    /**
     * Autor: Mariel Hernández Reyes
     * Fecha: 27/10/25
     * Descripción: Gestiona las transacciones de la ingredientes
     */

require_once 'conection.php';

class ADIngredientes{

    public static function listarTacos(){
        $stmt = conection::conectar()->prepare("SELECT idIngrediente, nombre FROM ingredientes WHERE categoria = 1");
        $stmt->execute();

        $lista = array();
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
            $lista[] = $fila;
        }
        return $lista;
    }

    public static function listarTortas(){
        $stmt = conection::conectar()->prepare("SELECT idIngrediente, nombre FROM ingredientes WHERE categoria = 3");
        $stmt->execute();

        $lista = array();
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
            $lista[] = $fila;
        }
        return $lista;
    }

    public static function listarBebidas(){
        $stmt = conection::conectar()->prepare("SELECT idIngrediente, nombre FROM ingredientes WHERE categoria = 2");
        $stmt->execute();

        $lista = array();
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
            $lista[] = $fila;
        }
        return $lista;
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