<!DOCTYPE html>
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
                <li><a href="index.html">Inicio</a></li>
                <li><a href="#">Menú</a></li>
                <li><a href="carrito.html">Carrito</a></li>
            </ul>
        </nav>
        <button id="user-button" class="user-active active-profile-button">Juan Pérez</button> 
    </header>

    <main class="profile-main">
        <div class="profile-grid">
            
            <aside class="profile-sidebar">
                <nav>
                    <ul>
                        <li><a href="#" class="sidebar-link active-sidebar-link" id="link-personal">Información personal</a></li>
                        <li><a href="#" class="sidebar-link" id="link-orders">Mis pedidos</a></li>
                        <li><a href="#" class="sidebar-link" id="link-logout">Cerrar sesión</a></li>
                    </ul>
                </nav>
            </aside>

            <section class="profile-content">
                
                <h2 class="profile-greeting">Hola, Juan Pérez</h2>
                
                <div id="personal-info-container" class="profile-info-panel active-panel">
                    <div class="form-title">Información personal</div>
                    
                    <form class="profile-form">
                        
                        <input type="text" value="Juan" class="profile-input" placeholder="Nombre(s)">
                        <input type="text" value="Pérez López" class="profile-input" placeholder="Apellidos">

                        <input type="date" value="1985-02-15" class="profile-input" id="birth-date-input">
                        
                        <input type="text" value="Av. del Trabajo s/n Tlahuelilpan" class="profile-input" placeholder="Dirección">

                        <select class="profile-input" id="gender-select">
                            <option value="masculino" selected>Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="otro">Otro</option>
                            <option value="prefiero_no_decir">Prefiero no decir</option>
                        </select>
                        
                        <input type="email" value="juanperez@gmail.com" class="profile-input" placeholder="Correo Electrónico">

                        <div class="password-wrapper">
                            <input type="password" value="password123" class="profile-input" placeholder="Contraseña">
                            <button type="button" class="toggle-password"><img src="../assets/css/ojoabierto.png" alt="Ver"></button> 
                        </div>
                        <div class="password-wrapper">
                            <input type="password" value="password123" class="profile-input" placeholder="Confirmar Contraseña">
                            <button type="button" class="toggle-password"><img src="../assets/css/ojoabierto.png" alt="Ver"></button>
                        </div>

                        <div class="full-width-control">
                            <button type="submit" class="save-changes-button">Guardar cambios</button>
                        </div>
                    </form>
                </div>
                
                <div id="orders-container" class="profile-info-panel hidden">
                    
                    <div class="order-card">
                        <img src="../assets/css/logosolotaco.png" alt="Taco" class="order-image">
                        <div class="order-details">
                            <span class="order-id">Pedido #225</span>
                            <span class="order-date">10 de octubre, 2025</span>
                            <span class="order-total">Total: $XXXX.00</span>
                        </div>
                        <div class="order-status finished">Terminado</div>
                    </div>
                    
                    <div class="order-card">
                        <img src="../assets/css/logosolotaco.png" alt="Taco" class="order-image">
                        <div class="order-details">
                            <span class="order-id">Pedido #226</span>
                            <span class="order-date">10 de octubre, 2025</span>
                            <span class="order-total">Total: $XXXX.00</span>
                        </div>
                        <div class="order-status in-progress">En proceso</div>
                    </div>
                    
                    <div class="order-card">
                        <img src="../assets/css/logosolotaco.png" alt="Taco" class="order-image">
                        <div class="order-details">
                            <span class="order-id">Pedido #227</span>
                            <span class="order-date">10 de octubre, 2025</span>
                            <span class="order-total">Total: $XXXX.00</span>
                        </div>
                        <div class="order-status pending">En espera</div>
                    </div>
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
                    profileGreeting.textContent = "Hola, Juan Pérez";
                    document.getElementById('link-personal').classList.add('active-sidebar-link');
                } else if (targetId === 'orders') {
                    document.getElementById('orders-container').classList.remove('hidden');
                    profileGreeting.textContent = "Hola, Juan Pérez"; 
                    document.getElementById('link-orders').classList.add('active-sidebar-link');
                } else if (targetId === 'logout') {
                    document.getElementById('link-logout').classList.add('active-sidebar-link');
                    alert('Cerrando sesión...');
                    // window.location.href = 'login.html'; // Redirección real
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
                });
            });

            // Simulación de guardar cambios
            const profileForm = document.querySelector('.profile-form');
            if (profileForm) {
                 profileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Aquí puedes obtener los valores de los selectores
                    const birthDate = document.getElementById('birth-date-input').value;
                    const gender = document.getElementById('gender-select').value;
                    
                    console.log('Fecha de nacimiento:', birthDate);
                    console.log('Género seleccionado:', gender);

                    alert('¡Cambios guardados con éxito!');
                });
            }

            // Inicializa mostrando el panel de "Información personal"
            switchProfilePanel('personal');
        });
    </script>
</body>
</html>
