<!DOCTYPE html>
<?php
SESSION_START();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="profile.css"> 
</head>
<body>
    <header id="main-header">
        <div class="logo-container">
            <img src="../assets/css/logosolotaco.png" alt="Logo El Gallo Giro" id="logo">
            <div class="brand-text">
                <h1>Taquería</h1>
                <h2>El Gallo Giro</h2>
            </div>
        </div>
        <nav id="main-nav">
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li class="despliegue">
                    <a href="inicio.php">Menú</a>
                    <div class="despliegue-content">
                        <a href="Tacos.php">Tacos</a>
                        <a href="Tortas.php">Tortas</a>
                        <a href="Bebidas.php">Bebidas</a>
                    </div>

                </li>
                <li><a href="cart.php">Carrito</a></li>
            </ul>
        </nav>
        <button id="user-button" class="user-active active-profile-button"> 
            <?php 
                 if (empty($_SESSION['nombre'])) {
                 echo "";
                 } else {
                     echo htmlspecialchars($_SESSION['nombre']);
                }
            ?>
        </button> 
    </header>

    <main class="profile-main">
        <div class="profile-grid">
            
            <aside class="profile-sidebar">
                <nav>
                    <ul>
                        <li><a href="#" class="sidebar-link active-sidebar-link" id="link-personal">Información personal</a></li>
                        <li><a href="#" class="sidebar-link" id="link-orders">Mis pedidos</a></li>
                        <li><a href="../controlador/logout.php" class="sidebar-link" id="link-logout">Cerrar sesión</a></li>
                    </ul>
                </nav>
            </aside>

            <section class="profile-content">
                
                <h2 class="profile-greeting">
                    <?php 
                        if (empty($_SESSION['nombre'])) {
                        echo "Perfil";
                        } else {
                        echo htmlspecialchars($_SESSION['nombre']);
                        }
                    ?>
                </h2>
                
                <div id="personal-info-container" class="profile-info-panel active-panel">
                    <div class="form-title">Información personal</div>
                    
                    <form class="profile-form" action="../controlador/CUsuario.php" method="POST">
                        
                        <input type="text" value="<?php echo !empty($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : ''; ?>" name="nombre" class="profile-input" placeholder="Nombre(s)" required pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras y espacios.">

                        <input type="text" value="<?php echo !empty($_SESSION['apellidos']) ? htmlspecialchars($_SESSION['apellidos']) : ''; ?>" name="apellidos" class="profile-input" placeholder="Apellidos" required pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras y espacios.">

                        <input type="date" value="<?php echo !empty($_SESSION['fechaNac']) ? htmlspecialchars($_SESSION['fechaNac']) : ''; ?>" name="fechaNac" class="profile-input" id="birth-date-input">
                        
                        <input type="text" value="<?php echo !empty($_SESSION['direccion']) ? htmlspecialchars($_SESSION['direccion']) : ''; ?>" name="direccion" class="profile-input" placeholder="Dirección" required>

                        <select class="profile-input" id="gender-select" name="genero">
                            <option value="1" <?php if ($_SESSION['genero'] == 1) echo 'selected'; ?>>Masculino</option>
                            <option value="2" <?php if ($_SESSION['genero'] == 2) echo 'selected'; ?>>Femenino</option>
                            <option value="otro">Otro</option>
                            <option value="prefiero_no_decir">Prefiero no decir</option>
                        </select>

                        <input type="email" value="<?php echo !empty($_SESSION['correo']) ? htmlspecialchars($_SESSION['correo']) : ''; ?>" name="correo" class="profile-input" placeholder="Correo Electrónico" required>

                        <div class="password-wrapper">
                            <input type="password" value="<?php echo !empty($_SESSION['passwor']) ? htmlspecialchars($_SESSION['passwor']) : '';?>" name="passwor" class="profile-input" placeholder="Contraseña" required minlength="8">
                            <button type="button" class="toggle-password"><img src="../assets/css/ojoabierto.png" alt="Ver"></button> 
                        </div>
                        <div class="password-wrapper">
                            <input type="password" value="<?php echo !empty($_SESSION['passwor']) ? htmlspecialchars($_SESSION['passwor']) : '';?>" name="confirm_password" class="profile-input" placeholder="Confirmar Contraseña" required minlength="8">
                            <button type="button" class="toggle-password"><img src="../assets/css/ojoabierto.png" alt="Ver"></button>
                        </div>

                        <div class="full-width-control">
                            <button type="submit" class="save-changes-button">Guardar cambios</button>
                        </div>
                    </form>
                </div>
                
                <div id="orders-container" class="profile-info-panel hidden">
                     <?php include "../controlador/CPedido.php"; ?>
                </div>
               
            </section>
        </div>
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            const profilePanels = document.querySelectorAll('.profile-info-panel');
            const profileGreeting = document.querySelector('.profile-greeting');

            function switchProfilePanel(targetId) {
                // Oculta todos los paneles de contenido y remueve la clase activa de los enlaces
                profilePanels.forEach(panel => {
                    panel.classList.add('hidden');
                });
                sidebarLinks.forEach(l => l.classList.remove('active-sidebar-link'));

                // Muestra el panel y actualiza el título
                if (targetId === 'personal') {
                    document.getElementById('personal-info-container').classList.remove('hidden');
                    profileGreeting.textContent = "Hola, <?php echo $_SESSION['nombre']; ?>";
                    document.getElementById('link-personal').classList.add('active-sidebar-link');
                } else if (targetId === 'orders') {
                    document.getElementById('orders-container').classList.remove('hidden');
                    profileGreeting.textContent = "Hola, <?php echo $_SESSION['nombre']; ?>"; 
                    document.getElementById('link-orders').classList.add('active-sidebar-link');
                } else if (targetId === 'logout') {
                    document.getElementById('link-logout').classList.add('active-sidebar-link');
                    alert('Cerrando sesión...');
                     window.location.href = '../controlador/logout.php'; // Redirección real
                }
            }

            // Manejador de eventos para la barra lateral
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.id.replace('link-', ''); 
                    switchProfilePanel(targetId);
                });
            });
// Funcionalidad de mostrar/ocultar contraseña
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {

        const passwordInput = this.previousElementSibling;
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';

        // Cambiar ícono
        const icon = this.querySelector("img");
        const eyeOpenSrc = "../assets/css/ojoabierto.png";
        const eyeClosedSrc = "../assets/css/ojocerrado.png";

        if (isPassword) {
            icon.src = eyeClosedSrc;
            icon.alt = "Ocultar contraseña";
        } else {
            icon.src = eyeOpenSrc;
            icon.alt = "Mostrar contraseña";
        }
    });
});

            // Inicializa mostrando el panel de "Información personal"
            switchProfilePanel('personal');
        });
    </script>
</body>
</html>
