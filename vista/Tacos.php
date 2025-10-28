<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Tacos - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
    <link rel="stylesheet" href="menu.css"> 
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
                        <a href="Bebidas.php">Tortas</a>
                        <a href="Tortas.php">Bebidas</a>
                    </div>

                </li>
                <li><a href="#">Carrito</a></li>
            </ul>
        </nav>
        <button id="login-button">Iniciar Sesión</button>
    </header>


    <main class="menu-main">
        <section id="menu-grid-section">
            <h2>Menú de Tacos</h2>
            
            <div class="dishes-grid menu-tacos-grid">
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Tacos de carne molida">
                    </div>
                    <h3>Tacos de carne molida</h3>
                    <p class="price">$17.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="1"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Tacos al pastor">
                    </div>
                    <h3>Tacos al pastor</h3>
                    <p class="price">$14.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="2"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Tacos de chorizo">
                    </div>
                    <h3>Tacos de chorizo</h3>
                    <p class="price">$19.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="3"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>

                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Tacos de suadero">
                    </div>
                    <h3>Tacos de suadero</h3>
                    <p class="price">$19.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="4"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>

                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Tacos de longaniza">
                    </div>
                    <h3>Tacos de longaniza</h3>
                    <p class="price">$18.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="5"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>

                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Tacos de camarón">
                    </div>
                    <h3>Tacos de camarón</h3>
                    <p class="price">$25.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="6"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
            </div>
        </section>
    </main>
    
    <div id="complements-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            
            <div class="modal-body">
                
                <div class="modal-product-image">
                    <img src="../assets/css/tacosalpastor.png" alt="Tacos de carne molida">
                </div>
                
                <div class="modal-product-details">
                    <h3>Tacos de carne molida</h3>
                    <p class="complement-label">Complementos adicionales</p>
                    
                    <div class="complement-options">
                        <button class="complement-button">Cilantro</button>
                        <button class="complement-button">Cebolla</button>
                        <button class="complement-button">Piña</button>
                        <button class="complement-button">Salsa verde</button>
                        <button class="complement-button active-complement">Salsa roja</button>
                        <button class="complement-button">Guacamole</button>
                    </div>

                    <div class="modal-footer-controls">
                        <span class="product-price-modal">$17.00 c/u</span>
                        
                        <div class="quantity-control">
                            <button class="quantity-button minus">-</button>
                            <span class="quantity-display">4</span>
                            <button class="quantity-button plus">+</button>
                        </div>
                        
                        <button class="add-to-cart-modal-button">
                            <img src="../assets/css/carrito.png" alt="Añadir">
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById("complements-modal");
        const openButtons = document.querySelectorAll(".open-modal");
        const closeButton = document.querySelector(".close-button");

        // Función para mostrar el modal
        openButtons.forEach(btn => {
            btn.onclick = function() {
                modal.style.display = "block";
            }
        });

        // Función para ocultar el modal al hacer clic en (X)
        closeButton.onclick = function() {
            modal.style.display = "none";
        }

        // Función para ocultar el modal al hacer clic fuera de él
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
        // Lógica de cantidad (simple)
        const minusButton = document.querySelector('.quantity-button.minus');
        const plusButton = document.querySelector('.quantity-button.plus');
        const quantityDisplay = document.querySelector('.quantity-display');

        if (minusButton && plusButton && quantityDisplay) {
            minusButton.addEventListener('click', () => {
                let currentQuantity = parseInt(quantityDisplay.textContent);
                if (currentQuantity > 1) {
                    quantityDisplay.textContent = currentQuantity - 1;
                }
            });

            plusButton.addEventListener('click', () => {
                let currentQuantity = parseInt(quantityDisplay.textContent);
                quantityDisplay.textContent = currentQuantity + 1;
            });
        }
    });
     document.addEventListener('DOMContentLoaded', function() {
        // ... (Tu código existente del modal, botones +/-, etc.) ...

        // ⬇️ NUEVO CÓDIGO PARA COMPLEMENTOS ⬇️
        const complementButtons = document.querySelectorAll('.complement-button');

        complementButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Al hacer clic, alterna la clase 'active-complement'.
                // Esto permite seleccionar y deseleccionar complementos.
                this.classList.toggle('active-complement');
            });
        });
        // ⬆️ FIN NUEVO CÓDIGO ⬆️

    });
</script>
    </body>
</html>
