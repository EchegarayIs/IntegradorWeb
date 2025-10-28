<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
    <link rel="stylesheet" href="login.css">
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
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Menú</a></li>
                <li><a href="#">Carrito</a></li>
            </ul>
        </nav>
        <button id="login-button" class="active-login-btn">Iniciar Sesión</button>
    </header>

    <main class="login-main">
        <section id="register-section">
            <div class="register-container">
                <h2>Registrarse</h2>

                <form class="register-form" method="POST" action="../controlador/registrarUsuario.php">
                    <div class="input-group">
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre(s)" required>
                    </div>
                    <div class="input-group">
                        <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>
                    </div>
                    
                    <div class="input-group select-group">
                        <input type="date" id="fechaNacimiento" name="fechaNacimiento" placeholder="Fecha de nacimiento">
                        <span class="placeholder-text-date">Fecha de nacimiento</span>
                        </div>
                    <div class="input-group">
                        <input type="text" id="direccion" name="direccion" placeholder="Dirección" required>
                    </div>

                    <div class="input-group select-group">
                        <select id="genero" name="genero" required>
                            <option value="" disabled selected>Género</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O">Otro</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="email" id="correo" name="correo" placeholder="Correo Electrónico" required>
                    </div>

                    <div class="input-group password-group">
                        <input type="password" id="reg-password" name="password" placeholder="Contraseña" required>
                        <span class="toggle-password">
                            <img src="../assets/css/ojoabierto.png" alt="Mostrar/Ocultar Contraseña" class="toggle-icon" data-target="reg-password">
                        </span>
                    </div>
                    <div class="input-group password-group">
                        <input type="password" id="confirm-password" name="confirmar" placeholder="Confirmar contraseña" required>
                        <span class="toggle-password">
                            <img src="../assets/css/ojoabierto.png" alt="Mostrar/Ocultar Contraseña" class="toggle-icon" data-target="confirm-password">
                        </span>
                    </div>
                    
                    <div class="button-group full-width-buttons">
                        <button type="submit" class="submit-button">Registrarme</button>
                        <button type="button" class="cancel-button" onclick="window.location.href='login.php'">Cancelar</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleIcons = document.querySelectorAll('.toggle-icon');
            
            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    // Obtiene el ID del input asociado desde el atributo data-target
                    const targetId = this.getAttribute('data-target');
                    const passwordField = document.getElementById(targetId);

                    if (passwordField) {
                        const isPassword = passwordField.getAttribute('type') === 'password';
                        const newType = isPassword ? 'text' : 'password';
                        passwordField.setAttribute('type', newType);

                        // RUTA DE ICONOS: Asegúrate que estas rutas sean correctas
                        const eyeOpenSrc = "../assets/css/ojoabierto.png"; 
                        const eyeClosedSrc = "../assets/css/ojocerrado.png"; 

                        if (isPassword) {
                            this.src = eyeOpenSrc;
                            this.alt = "Ocultar Contraseña";
                        } else {
                            this.src = eyeClosedSrc;
                            this.alt = "Mostrar Contraseña";
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
