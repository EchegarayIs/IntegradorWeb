<!DOCTYPE html>


<?php
    session_start();
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Gallo Giro</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <h1>¡Ups! Algo salió mal</h1>
            <fieldset>
            <legend>Información del error</legend>
                <p><?php echo $_SESSION['errormsj']?></<p>
            </fieldset>
            <div class="error-actions">
                <a href="../index.php" class="btn btn-primary">Volver al inicio</a>
            </div>
        </div>
    </div>
</body>
</html>