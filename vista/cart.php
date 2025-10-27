<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
    <link rel="stylesheet" href="menu.css"> 
    <link rel="stylesheet" href="cart.css"> </head>
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
                <li class="active-menu-link"><a href="#">Carrito</a></li> </ul>
        </nav>
        <button id="user-button" class="user-active">Juan Pérez</button>
    </header>

    <main class="cart-main">
        <section id="cart-content">
            <div class="cart-grid">
                
                <div class="cart-items-container">
                    <h2>Tu pedido</h2>

                    <div class="cart-item-card">
                        <div class="item-details">
                            <div class="item-image-container">
                                <img src="../assets/css/tacosalpastor.png" alt="Coca Cola">
                            </div>
                            <span class="item-name">Coca Cola</span>
                        </div>
                        
                        <span class="item-price">$75.00</span>
                        
                        <div class="item-controls">
                            <div class="quantity-control small-control">
                                <button class="quantity-button minus">-</button>
                                <span class="quantity-display">3</span>
                                <button class="quantity-button plus">+</button>
                            </div>
                            <button class="remove-item-button">
                                <img src="../assets/css/botebasura.png" alt="Eliminar"> </button>
                        </div>
                    </div>

                    <div class="cart-item-card">
                        <div class="item-details">
                            <div class="item-image-container">
                                <img src="../assets/css/tacosalpastor.png" alt="Tacos de carne molida">
                            </div>
                            <span class="item-name">Tacos de carne molida</span>
                        </div>
                        
                        <span class="item-price">$68.00</span>
                        
                        <div class="item-controls">
                            <div class="quantity-control small-control">
                                <button class="quantity-button minus">-</button>
                                <span class="quantity-display">4</span>
                                <button class="quantity-button plus">+</button>
                            </div>
                            <button class="remove-item-button">
                                <img src="../assets/css/botebasura.png" alt="Eliminar">
                            </button>
                        </div>
                    </div>
                    
                    </div>

                <div class="ticket-container">
                    <h3>Ticket de compra</h3>
                    <div class="summary-line">
                        <span>Subtotal:</span>
                        <span class="summary-value">XXXXXXX</span>
                    </div>
                    <hr class="summary-divider">
                    <div class="summary-line total-line">
                        <span>Total:</span>
                        <span class="summary-value">XXXXXXX</span>
                    </div>
                    <div class="final-price">
                        $XXXXXX.00
                    </div>

                    <button class="checkout-button">
                        Proceder al pago
                    </button>
                </div>
                
            </div>
        </section>
    </main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. CONFIGURACIÓN INICIAL Y CÁLCULO ---
        
        // Define el precio por unidad para cada producto (simulado)
        // En una app real, esto vendría del backend.
        const PRODUCT_PRICES = {
            'Coca Cola': 25.00,  // Precio base por unidad
            'Tacos de carne molida': 17.00 // Precio base por unidad
            // Agrega más productos aquí si es necesario
        };

        const SHIPPING_COST = 0; // Se elimina el costo de envío, por lo que es 0

        /**
         * Calcula el subtotal, total y actualiza el ticket de compra.
         */
        function updateCartSummary() {
            let subtotal = 0;
            const itemCards = document.querySelectorAll('.cart-item-card');

            itemCards.forEach(card => {
                const nameElement = card.querySelector('.item-name');
                const quantityElement = card.querySelector('.quantity-display');
                const priceElement = card.querySelector('.item-price');

                if (nameElement && quantityElement && priceElement) {
                    const productName = nameElement.textContent.trim();
                    const quantity = parseInt(quantityElement.textContent);
                    // Usamos un precio base por unidad (ajusta la lógica si el precio ya es por 4 tacos, etc.)
                    const pricePerUnit = PRODUCT_PRICES[productName] || 0; 
                    
                    const itemTotal = pricePerUnit * quantity;
                    
                    // Actualiza el precio visible total del ítem (ej: $75.00 en la imagen)
                    priceElement.textContent = `$${itemTotal.toFixed(2)}`;
                    
                    subtotal += itemTotal;
                }
            });

            const total = subtotal + SHIPPING_COST;

            // Actualiza los elementos del Ticket
            document.querySelector('.summary-line:nth-child(2) .summary-value').textContent = `$${subtotal.toFixed(2)}`; // Subtotal
            document.querySelector('.summary-line:nth-child(4) .summary-value').textContent = `$${subtotal.toFixed(2)}`; // Total (antes de envío)
            document.querySelector('.summary-line:nth-child(5) .summary-value').textContent = (SHIPPING_COST === 0) ? 'Gratis' : `$${SHIPPING_COST.toFixed(2)}`; // Costo de envío
            document.querySelector('.final-price').textContent = `$${total.toFixed(2)}`; // Precio Final
        }

        // --- 2. MANEJO DE CANTIDAD Y ELIMINACIÓN ---

        const cartContainer = document.querySelector('.cart-items-container');
        
        // Delegamos los eventos al contenedor principal para eficiencia
        cartContainer.addEventListener('click', function(event) {
            const button = event.target.closest('button');
            if (!button) return;

            const itemCard = button.closest('.cart-item-card');
            if (!itemCard) return;

            const quantityDisplay = itemCard.querySelector('.quantity-display');
            let currentQuantity = parseInt(quantityDisplay.textContent);

            // Botón de AUMENTAR (+)
            if (button.classList.contains('plus')) {
                currentQuantity += 1;
                quantityDisplay.textContent = currentQuantity;
                updateCartSummary();

            // Botón de DISMINUIR (-)
            } else if (button.classList.contains('minus')) {
                if (currentQuantity > 1) {
                    currentQuantity -= 1;
                    quantityDisplay.textContent = currentQuantity;
                    updateCartSummary();
                }

            // Botón de ELIMINAR (Bote de basura)
            } else if (button.classList.contains('remove-item-button')) {
                // Muestra la alerta
                const itemName = itemCard.querySelector('.item-name').textContent;
                const confirmDelete = confirm(`¿Estás seguro de que quieres eliminar "${itemName}" del carrito?`);
                
                if (confirmDelete) {
                    itemCard.remove(); // Elimina la tarjeta del producto del DOM
                    updateCartSummary(); // Vuelve a calcular el total
                    
                    // Opcional: Si el carrito queda vacío, mostrar un mensaje
                    if (document.querySelectorAll('.cart-item-card').length === 0) {
                        cartContainer.innerHTML = '<h2>Tu pedido</h2><p>Tu carrito está vacío.</p>';
                    }
                }
            }
        });

        // Inicializa el cálculo al cargar la página
        updateCartSummary();
    });
</script>
    </body>
</html>
