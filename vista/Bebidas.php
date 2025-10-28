<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Bebidas - Taquería El Gallo Giro</title>
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
                    
                    <div class="complement-options" id="complementos-contenedor">
                        
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
        document.addEventListener('DOMContentLoaded', function() {
        // Cargar complementos desde la base de datos
        function cargarComplementos() {
            fetch(`http://localhost/IntegradorWeb/modelo/conexion/ApiIngredientes.php?api=listarBebidas`)
                .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
                
            }).then(data => {
                    const complementOptionsContainer = document.getElementById('complementos-contenedor');
                    complementOptionsContainer.innerHTML = ''; // Limpiar el contenido existente

                    data.contenido.forEach(complemento => {
                        const complementButton = document.createElement('button');
                        complementButton.classList.add('complement-button');
                        complementButton.textContent = complemento.nombre;

                        complementButton.addEventListener('click', function() {
                            this.classList.toggle('active-complement');
                        });

                        complementOptionsContainer.appendChild(complementButton);
                    });
                })
                .catch(error=>console.error('Error al cargar los complementos:', error));
        }
        cargarComplementos();
    });
    </script>
</body>
</html>
