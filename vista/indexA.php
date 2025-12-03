<!DOCTYPE html>
<?php
SESSION_start();

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
            <ul >
                <li><a href="#" class="active">Inicio</a></li>
            </ul>
        </nav>
        <button id="user-button" class="user-active" onclick="window.location.href='admin.php'"><?php echo htmlspecialchars($_SESSION['nombre']);?></button>
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
                <p>El auténtico sabor de México en cada bocado. Disfruta de los mejores tacos de la región.</p>
                
            </div>
            
            <div class="footer-section contact-info">
                <h3>Contacto</h3>
                <ul>
                    <li>📞 Teléfono: 55 3944 9958</li>
                    <li>ⓕ  Facebook: El Gallo Giro Tlahuelilpan</li>
                    <li>🕒 Horario: Lun - Sáb: 10:00 - 23:00</li>
                </ul>
            </div>
            
            <div class="footer-section location-info">
                <h3>Ubicación</h3>
                <p>La Ranchería, Rancho Viejo, 42783 Tlahuelilpan, Hgo. #456</p>
                <a href="https://maps.app.goo.gl/EGMkjwspU3VL5xX29" target="_blank" class="map-link">Ver en Mapa</a>
            </div>

        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Taquería El Gallo Giro. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
