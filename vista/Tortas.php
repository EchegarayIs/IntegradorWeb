<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Tortas - Taquería El Gallo Giro</title>
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
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="#">Menú</a></li>
                <li><a href="cart.html">Carrito</a></li>
            </ul>
        </nav>
        <button id="user-button" class="user-active">Juan Pérez</button>
    </header>

    <main class="menu-main">
        <section id="menu-grid-section">
            <h2>Menú de Tortas</h2>
            
            <div class="dishes-grid menu-tortas-grid">
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Torta de pierna">
                    </div>
                    <h3>Torta de pierna</h3>
                    <p class="price">$45.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="101"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Torta de tres quesos">
                    </div>
                    <h3>Torta de tres quesos</h3>
                    <p class="price">$68.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="102"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Torta cubana">
                    </div>
                    <h3>Torta cubana</h3>
                    <p class="price">$57.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="103"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>

                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Torta de milanesa">
                    </div>
                    <h3>Torta de milanesa</h3>
                    <p class="price">$52.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="104"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>

                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Torta de jamón">
                    </div>
                    <h3>Torta de jamón</h3>
                    <p class="price">$42.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="105"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>

                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Torta de huevo">
                    </div>
                    <h3>Torta de huevo</h3>
                    <p class="price">$38.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="106"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
            </div>
        </section>
    </main>
    
    <div id="complements-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            
            <div class="modal-body">
                
                <div class="modal-product-image">
                    <img src="../assets/css/tacosalpastor.png" alt="Torta de tres quesos">
                </div>
                
                <div class="modal-product-details">
                    <h3>Torta de tres quesos</h3>
                    <p class="complement-label">Complementos adicionales</p>
                    
                    <div class="complement-options">
                        <button class="complement-button active-complement">Jitomate</button>
                        <button class="complement-button">Cebolla</button>
                        <button class="complement-button">Aguacate</button>
                        <button class="complement-button">Chiles en rajas</button>
                        <button class="complement-button active-complement">Chipotle</button>
                        <button class="complement-button">Mayonesa</button>
                    </div>

                    <div class="modal-footer-controls">
                        <span class="product-price-modal">$68.00 c/u</span>
                        
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
            // Lógica del modal (reutilizada)
            const modal = document.getElementById("complements-modal");
            const openButtons = document.querySelectorAll(".open-modal");
            const closeButton = document.querySelector(".close-button");

            openButtons.forEach(btn => {
                btn.onclick = function() {
                    modal.style.display = "block";
                    // En una aplicación real, aquí se actualizaría la imagen, título y precio del modal
                }
            });

            closeButton.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            
            // Lógica de cantidad (reutilizada)
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
            
            // Lógica de complementos (reutilizada)
            const complementButtons = document.querySelectorAll('.complement-button');

            complementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.toggle('active-complement');
                });
            });
        });
    </script>
</body>
</html>
