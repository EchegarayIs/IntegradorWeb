<?php
// ... (Código anterior de inclusión y lógica) ...
require_once "../modelo/conexion/Conexion.php";
require_once "../modelo/Mreporte.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fechaInicio = trim($_POST["fecha_inicio"]);
    $fechaFin = trim($_POST["fecha_fin"]);

    $reporte = new Mreporte();
    $reporteVentas = $reporte->generarReporteVentas($fechaInicio, $fechaFin);

    $fechaGeneracion = date('Y-m-d H:i:s');
    $name_report = "Reporte_Ventas_" . date('Ymd') . ".xls";

    // Encabezados para forzar la descarga como archivo Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$name_report\"");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Inicio del HTML con estilo de letra (Arial) y estilos de borde para la tabla
    echo "<html>";
    echo "<meta charset='UTF-8'>";
    // Estilo de cuerpo general (fuente)
    echo "<body style='font-family: Arial, sans-serif;'>"; 

    // Información General del Reporte
    // Información General del Reporte
    echo "<h1 style='color: #2F528F;'>Reporte de Ventas Detallado</h1>";
    echo "<img src='../assets/css/tacosalpastor.png' style='width:120px;'><br>";
    echo "<p><strong>Período:</strong> Desde el " . $fechaInicio . " hasta el " . $fechaFin . "</p>";
    echo "<p><strong>Generado el:</strong> " . $fechaGeneracion . "</p>";
    echo "<br>";

    // Definición de Estilos
    // Estilo de la tabla (usamos border-collapse para bordes simples)
    $tableStyle = "style='border-collapse: collapse; width: 100%;'";
    
    // Estilo para el encabezado: Azul oscuro y texto blanco
    $headerStyle = "style='background-color: #2F528F; color: white; font-weight: bold; text-align: center; border: 1px solid #1F3864;'"; 
    
    // Estilo para celdas de datos (borde y padding)
    $cellStyle = "style='border: 1px solid #ccc; padding: 4px;'"; 
    $montoStyle = "style='text-align: right; border: 1px solid #ccc; padding: 3px;'";

    echo "<img src='../assets/css/tacosalpastor.png' alt='Tacos al pastor' style='width:100px;'><br>";

    // Inicio de la Tabla
    echo "<table " . $tableStyle . ">";
    
    // Encabezados de la tabla
    echo "<tr >";
    echo "<th " . $headerStyle . ">N°</th>";
    echo "<th " . $headerStyle . ">ID Pedido</th>";
    echo "<th " . $headerStyle . ">Monto Total ($)</th>";
    echo "<th " . $headerStyle . ">Método de Pago</th>";
    echo "<th " . $headerStyle . ">Fecha del Pedido</th>";
    echo "<th " . $headerStyle . ">Empleado</th>";
    echo "<img src='../assets/css/tacosalpastor.png' alt='Tacos mexicanos'>";
    echo "</tr>";
    
    // Datos del reporte y cálculo de Total General
    $i = 1;
    $totalGeneral = 0; 
    foreach ($reporteVentas as $venta) {
        $totalGeneral += $venta->monto; 
        
        // Estilo de fila alternado para mejor lectura
        $rowColor = ($i % 2 == 0) ? "background-color: #F8F8F8;" : "background-color: #FFFFFF;"; // Gris muy claro vs Blanco
        $rowStyle = "style='" . $rowColor . "'";

        echo "<tr " . $rowStyle . ">";
        echo "<td " . $cellStyle . " style='text-align: center;'>" . $i . "</td>";
        echo "<td " . $cellStyle . ">" . $venta->idPedido . "</td>";
        echo "<td " . $montoStyle . ">" . number_format($venta->monto, 2, '.', ',') . "</td>";
        echo "<td " . $cellStyle . ">" . $venta->metodoPago . "</td>";
        echo "<td " . $cellStyle . ">" . $venta->fechaPedido . "</td>";
        echo "<td " . $cellStyle . ">" . $venta->empleado . "</td>";
        echo "</tr>";
        $i++;
    }

    // Fila de Total General
    // Estilo de total: Verde claro, negrita, alineación y borde fuerte
    $totalStyle = "style='background-color: #E6F3E6; font-weight: bold; text-align: right; border: 2px solid #5cb85c; padding: 5px;'";
    
    echo "<tr>";
    echo "<td colspan='2' " . $totalStyle . " style='text-align: left;'>TOTAL GENERAL:</td>";
    echo "<td " . $totalStyle . ">" . number_format($totalGeneral, 2, '.', ',') . "</td>";
    echo "<td colspan='3' " . $totalStyle . "></td>"; 
    echo "</tr>";

    echo "</table>";
    echo "</body></html>";
    exit;
}
?>