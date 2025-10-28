<!DOCTYPE html>
<?php
    include_once "../modelo/conexion/conection.php"; // prueba de conexion
    $db = conection::conectar();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taquería El Gallo Giro - Responsivo</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
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
            <ul class="despliegue">
                <li><a href="#" class="active">Inicio</a></li>
                <li>
                    <a href="index.php">Menú</a>
                    <div class="despliegue-content">
                        <a href="Tacos.php">Tacos</a>
                        <a href="Tortas.php">Tortas</a>
                        <a href="Bebidas.php">Bebidas</a>
                    </div>

                </li>
                <li><a href="#">Carrito</a></li>
            </ul>
        </nav>
        <button id="login-button">Iniciar Sesión</button>
    </header>


    <main>
        <section id="hero-section">
            <div class="hero-content">
                <h3>Auténticos</h3>
                <h1>Tacos Mexicanos</h1>
                <p>Descubre nuestros sabores</p>
                <button class="order-button">Ordenar ahora</button>
            </div>
            <div class="hero-image-container">
                <img src="../assets/css/tacosalpastor.png" alt="Tacos mexicanos" id="hero-tacos">
            </div>
        </section>

        <section id="popular-dishes">
            <h2>Platillos Populares</h2>
            <div class="dishes-grid">
                <div class="dish-card">
                    <img src="../assets/css/tacosalpastor.png" alt="Tacos de carne molida">
                    <h3>Tacos de carne molida</h3>
                    <p>$17.00 c/u</p>
                    <button class="add-to-cart-button"><img src="../assets/css/carrito.png" alt="Agregar al carrito"></button>
                </div>
                <div class="dish-card">
                    <img src="../assets/css/tacosalpastor.png" alt="Tacos al pastor">
                    <h3>Tacos al pastor</h3>
                    <p>$14.00 c/u</p>
                    <button class="add-to-cart-button"><img src="../assets/css/carrito.png" alt="Agregar al carrito"></button>
                </div>
                <div class="dish-card">
                    <img src="../assets/css/tacosalpastor.png" alt="Torta cubana">
                    <h3>Torta cubana</h3>
                    <p>$57.00 c/u</p>
                    <button class="add-to-cart-button"><img src="../assets/css/carrito.png" alt="Agregar al carrito"></button>
                </div>
                <div class="dish-card">
                    <img src="../assets/css/tacosalpastor.png" alt="Tacos de chorizo">
                    <h3>Tacos de chorizo</h3>
                    <p>$19.00 c/u</p>
                    <button class="add-to-cart-button"><img src="../assets/css/carrito.png" alt="Agregar al carrito"></button>
                </div>
            </div>
        </section>
    </main>

    <footer id="main-footer">
        <div class="footer-content">
            
            <div class="footer-section brand-info">
                <h3>El Gallo Giro</h3>
                <p>El auténtico sabor de México en cada bocado. Servicio a domicilio rápido y platillos frescos.</p>
                <div class="social-links">
                    <a href="#"><img src="../assets/css/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="../assets/css/instagram.png" alt="Instagram"></a>
                    <a href="#"><img src="../assets/css/whatsapp.png" alt="WhatsApp"></a>
                </div>
            </div>
            
            <div class="footer-section contact-info">
                <h3>Contacto</h3>
                <ul>
                    <li>📞 Teléfono: (55) 1234 5678</li>
                    <li>📧 Email: contacto@gallogiro.mx</li>
                    <li>🕒 Horario: Lun - Sáb: 10:00 - 23:00</li>
                </ul>
            </div>
            
            <div class="footer-section location-info">
                <h3>Ubicación</h3>
                <p>Av. Principal #456, Colonia Juárez, Ciudad de México.</p>
                <a href="https://maps.google.com/?q=Av.+Principal+#456" target="_blank" class="map-link">Ver en Mapa</a>
            </div>

            <div class="footer-section links-menu">
                <h3>Menú Rápido</h3>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Menú Completo</a></li>
                    <li><a href="#">Términos y Condiciones</a></li>
                    <li><a href="#">Aviso de Privacidad</a></li>
                </ul>
            </div>

        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Taquería El Gallo Giro. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
