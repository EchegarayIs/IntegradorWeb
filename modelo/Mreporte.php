<?php

class Mreporte {
    public function generarReporteVentas($fechaInicio, $fechaFin) {
        $conexion = new Conexion();
        $cnx = $conexion->conectar();

        // Consulta para generar el reporte de ventas entre las fechas proporcionadas
        $stmt = $cnx->prepare("CALL dbintegrador1.sp_generarReporte(:fechaInicio, :fechaFin)");
        $stmt->bindParam(':fechaInicio', $fechaInicio);
        $stmt->bindParam(':fechaFin', $fechaFin);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $reporteVentas = $stmt->fetchAll();

        // Cerrar la conexión
        $conexion->cerrarConexion();

        // Retornar el reporte de ventas generado
        return $reporteVentas;
    }
}

?>