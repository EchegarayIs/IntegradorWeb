<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
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
            </ul>
        </nav>
    </header>

    <main class="login-main">
        <section id="login-section">
            
            <div class="login-image-container">
                <img src="../assets/css/tacosalpastor.png" alt="Tacos mexicanos" id="login-tacos-img">
            </div>

            <div class="login-form-container">
                <h2>Iniciar Sesión</h2>

                <form  action="../controlador/dispacherUsuario.php" method="POST" class="login-form"> <!-- Manda a llamar al dispacherUsuario.php y entregalos parametros -->
                    <div class="input-group">
                        <input type="email" id="usuario" name="usuario" placeholder="Ingrese el usuario" title="Ingrese un correo electrónico" required>
                    </div>
                    <div class="input-group password-group">
                        <input type="password" id="password" name="password" placeholder="Contraseña" required minlength="8">
                        <span class="toggle-password">
                            <img src="../assets/css/ojocerrado.png" alt="Mostrar/Ocultar Contraseña" id="togglePasswordIcon">
                        </span>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="submit-button">Ingresar</button>
                        <button type="button" class="cancel-button" onclick="window.location.href='index.php'">Cancelar</button>
                    </div>
                </form>

                <p class="signup-link">
                    ¿No tienes cuenta? <a href="register.php" class="register-link">Registrarse</a>
                </p>
            </div>
        </section>
    </main>
    
    <script>
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');
        const passwordField = document.getElementById('password');

        if (togglePasswordIcon && passwordField) {
            togglePasswordIcon.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Nota: Para cambiar el icono, necesitarías tener dos archivos de imagen (ojo abierto y ojo cerrado)
            });
        }


    </script>
</body>
</html>