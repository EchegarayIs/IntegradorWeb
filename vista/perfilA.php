<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>El Gallo Giro - Perfil</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
  <!-- ===== NAV SUPERIOR ===== -->
  <header class="nav">
    <h1>Taquería - El Gallo Giro</h1>
    <nav>
      <a href="indexA.php">Inicio</a>
      <a href="perfilA.php">Perfil</a>
    </nav>
  </header>

  <!-- ===== CONTENEDOR PRINCIPAL ===== -->
  <main class="container perfil-layout">
<!-- Contenido principal -->
    <section class="perfil-content">
      <h2>Hola, Juan Pérez</h2>
      <p>Selecciona una opción del menú lateral para continuar.</p>
    </section>

    <!-- Menú lateral -->
    <aside class="sidebar">
      <ul>
        <li>Inicio</li>
        
         <li class="submenu-container">
          <button class="submenu-btn">Menú ▾</button>
          <ul class="submenu">
            <li><a href="#">Tacos</a></li>
            <li><a href="#">Tortas</a></li>
            <li><a href="#">Bebidas</a></li>
          </ul>
        </li>

        <li>Pedidos</li>
        <li>Reportes</li>
        <li>personal</li>
        <li>Información personal</li>
        <li><a href="login.php" > Cerrar sesión </a></li>
      </ul>
    </aside>

    <script src="../controlador/sidebar.js"></script>
  </main>
</body>
</html>