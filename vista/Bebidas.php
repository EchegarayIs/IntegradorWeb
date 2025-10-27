<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Bebidas - Taquería El Gallo Giro</title>
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
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Menú</a></li>
                <li><a href="cart.php">Carrito</a></li>
            </ul>
        </nav>
        <button id="user-button" class="user-active">Juan Pérez</button>
    </header>

    <main class="menu-main">
        <section id="menu-grid-section">
            <h2>Menú de Bebidas</h2>
            
            <div class="dishes-grid menu-bebidas-grid">
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Coca Cola">
                    </div>
                    <h3>Coca Cola</h3>
                    <p class="price">$25.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="201"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Seven up">
                    </div>
                    <h3>Seven up</h3>
                    <p class="price">$68.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="202"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Jarrito de manzana">
                    </div>
                    <h3>Jarrito de manzana</h3>
                    <p class="price">$57.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="203"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>

                <div class="dish-card menu-card">
                    <div class="card-image-container">
                        <img src="../assets/css/tacosalpastor.png" alt="Agua Natural">
                    </div>
                    <h3>Agua Natural</h3>
                    <p class="price">$15.00 c/u</p>
                    <button class="add-to-cart-button open-modal" data-product-id="204"><img src="../assets/css/carrito.png" alt="Agregar"></button>
                </div>
                
            </div>
        </section>
    </main>
    
    <div id="complements-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            
            <div class="modal-body">
                
                <div class="modal-product-image">
                    <img src="../assets/css/tacosalpastor.png" alt="Coca Cola">
                </div>
                
                <div class="modal-product-details">
                    <h3>Coca Cola</h3>
                    <p class="complement-label">Complementos adicionales</p>
                    
                    <div class="complement-options">
                        <button class="complement-button active-complement">355 ml</button>
                        <button class="complement-button">500 ml</button>
                        <button class="complement-button">600 ml</button>
                        
                        <button class="complement-button">Al tiempo</button>
                        <button class="complement-button active-complement">Fría</button>
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
            // Lógica del modal
            const modal = document.getElementById("complements-modal");
            const openButtons = document.querySelectorAll(".open-modal");
            const closeButton = document.querySelector(".close-button");

            openButtons.forEach(btn => {
                btn.onclick = function() {
                    modal.style.display = "block";
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
            
            // Lógica de cantidad
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
            
            // Lógica de complementos (selección naranja)
            const complementButtons = document.querySelectorAll('.complement-button');

            complementButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Mantiene el toggle para permitir múltiples selecciones si el usuario lo necesita
                    this.classList.toggle('active-complement');
                });
            });
        });
    </script>
</body>
</html>
