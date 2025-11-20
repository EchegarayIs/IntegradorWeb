<?php

session_start();

require_once "../modelo/conexion/Conexion.php";
require_once "../modelo/productos.php";
require_once "../modelo/complementos.php";

// Crear el despachasdor de eventos
try {

    $accion = $_POST['accion'];
    switch ($accion) {
        case 'bebidas':
            // Consultar los productos de bebidas
            $productoModel = new productos();
            $productos = $productoModel->consultarProductos();
            // Consulta los complementos de bebidas
            $complementoModel = new complementos();
            $complementosB = $complementoModel->listarBebidas();

            echo "<script>console.log('Productos: " . json_encode($productos) . "');</script>";

            // Almacenar los productos en la sesión para pasarlos a la vista
            $_SESSION['productos'] = $productos;
            $_SESSION['complementosB'] = $complementosB;

            header("Location: ../vista/Bebidas.php");
            break;
            case 'tacos':
                // Consultar los productos de bebidas
                $productoModel = new productos();
                $productosT = $productoModel->consultarProductos();
                // Consulta los complementos de bebidas
                $complementoModel = new complementos();
                $complementosT = $complementoModel->listarTacos();

                echo "<script>console.log('Productos: " . json_encode($productosT) . "');</script>";

                // Almacenar los productos en la sesión para pasarlos a la vista
                $_SESSION['productosT'] = $productosT;
                $_SESSION['complementosT'] = $complementosT;

                header("Location: ../vista/Tacos.php");
                break;
            case 'tortas':
                // Consultar los productos de bebidas
                $productoModel = new productos();
                $productos = $productoModel->consultarProductos();
                // Consulta los complementos de bebidas
                $complementoModel = new complementos();
                $complementosTorta = $complementoModel->listarTortas();

                echo "<script>console.log('Productos: " . json_encode($productos) . "');</script>";

                // Almacenar los productos en la sesión para pasarlos a la vista
                $_SESSION['productosTo'] = $productos; // Guarda los productos de tortas con la clave 'productosTo'
                $_SESSION['complementosTorta'] = $complementosTorta; // Guarda los complementos con la clave 'complementosTorta'
                header("Location: ../vista/Tortas.php");
                break;
        default:
            throw new Exception('Error en el sistema: Acción no reconocida');
    }

} catch (Exception $ex) {
    $_SESSION['errormsj'] = $ex->getMessage();
    header("Location: ../vista/errores.php");
}

?>