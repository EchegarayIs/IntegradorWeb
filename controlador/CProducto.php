<?php
require_once "../modelo/MProducto.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $precio = trim($_POST["precio"]);
    

    // Subida de imagen
    $imagen = "";
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaDestino = "../assets/css/" . $nombreArchivo;

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
            $imagen = $rutaDestino;
        } else {
            die("Error al subir la imagen.");
        }
    }

    $producto = new MProducto();
    $resultado = $producto->registrarProducto($nombre, $precio, $imagen);

    if ($resultado === true) {
        echo "<script>alert('✅ Producto registrado correctamente'); window.location.href='../vista/admin.php';</script>";
    } else {
        echo "<script>alert('❌ Error al registrar el producto ";
    }
}
?>
