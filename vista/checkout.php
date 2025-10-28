<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métodos de Pago - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
    <link rel="stylesheet" href="menu.css"> 
    <link rel="stylesheet" href="payment.css"> 
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
                <li class="despliegue">
                    <a href="#">Menú</a>
                    <div class="despliegue-content">
                        <a href="Tacos.php">Tacos</a>
                        <a href="Tortas.php">Tortas</a>
                        <a href="Bebidas.php">Bebidas</a>
                    </div>

                </li>
                <li class="active-menu-link"><a href="#">Carrito</a></li> </ul>
        </nav>
        <button id="user-button" class="user-active">Perfil</button>
    </header>

    <main class="payment-main">
        <section id="payment-methods-selection">
            <h2>Métodos de pago</h2>
            
            <div class="payment-options-grid">
                
                <div class="payment-option-card" id="option-cash">
                    <div class="option-icon">
                        <img src="../assets/css/dineroefectivo.png" alt="Icono Efectivo"> 
                    </div>
                    <span>Pago en efectivo</span>
                </div>
                
                <div class="payment-option-card" id="option-card">
                    <div class="option-icon">
                        <img src="../assets/css/tarjetacredito.png" alt="Icono Tarjeta"> 
                    </div>
                    <span>Pago con tarjeta</span>
                </div>
                
            </div>

            <button class="confirm-payment-method-button" id="confirm-method-button" style="display: none;">
                Confirmar método de pago
            </button>
        </section>

        <section id="cash-payment-details" class="payment-details-section hidden">
            <h2>Pago en efectivo</h2>
            <p class="payment-description">Prepara tu efectivo. Pagarás al recibir tu pedido</p>
            
            <div class="cash-icon-container">
                <img src="../assets/css/dineroefectivo.png" alt="Mano con efectivo"> 
            </div>

            <div class="payment-total">
                <span>Total a pagar:</span>
                <span class="final-amount">$XXXX.00</span>
            </div>

            <button class="confirm-payment-button">
                Confirmar método de pago
            </button>
        </section>

        <section id="card-payment-details" class="payment-details-section hidden">
            <h2>Pago con tarjeta</h2>
            
            <div class="card-form-grid">
                <div class="input-label">Número de tarjeta</div>
                <input type="text" placeholder="XXXX XXXX XXXX XXXX" class="card-input">

                <div class="input-label">Nombre del titular</div>
                <input type="text" placeholder="Nombre completo" class="card-input">
                
                <div class="input-label small-label">Vencimiento</div>
                <input type="text" placeholder="MM/AA" class="card-input small-input">

                <div class="input-label small-label">Código de seguridad</div>
                <input type="text" placeholder="CVV" class="card-input small-input">
            </div>

            <div class="payment-total">
                <span>Total a pagar:</span>
                <span class="final-amount">$XXXX.00</span>
            </div>

            <button class="pay-now-button">
                Pagar ahora
            </button>
        </section>
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const optionCash = document.getElementById('option-cash');
            const optionCard = document.getElementById('option-card');
            const confirmMethodButton = document.getElementById('confirm-method-button');
            
            const cashDetailsSection = document.getElementById('cash-payment-details');
            const cardDetailsSection = document.getElementById('card-payment-details');

            let selectedMethod = null; // Para rastrear qué método está seleccionado

            function hideAllPaymentDetails() {
                cashDetailsSection.classList.add('hidden');
                cardDetailsSection.classList.add('hidden');
                confirmMethodButton.style.display = 'none'; // Oculta el botón general
            }

            // Seleccionar Pago en Efectivo
            optionCash.addEventListener('click', function() {
                // Elimina la clase 'active' de todas las opciones primero
                document.querySelectorAll('.payment-option-card').forEach(card => {
                    card.classList.remove('active');
                });
                // Añade 'active' solo a la seleccionada
                this.classList.add('active');
                selectedMethod = 'cash';
                hideAllPaymentDetails(); // Oculta otros detalles si estuvieran visibles
                confirmMethodButton.style.display = 'block'; // Muestra el botón general
            });

            // Seleccionar Pago con Tarjeta
            optionCard.addEventListener('click', function() {
                document.querySelectorAll('.payment-option-card').forEach(card => {
                    card.classList.remove('active');
                });
                this.classList.add('active');
                selectedMethod = 'card';
                hideAllPaymentDetails(); // Oculta otros detalles si estuvieran visibles
                confirmMethodButton.style.display = 'block'; // Muestra el botón general
            });

            // Acción del botón "Confirmar método de pago" (Imagen 1)
            confirmMethodButton.addEventListener('click', function() {
                if (selectedMethod === 'cash') {
                    cashDetailsSection.classList.remove('hidden');
                    // Oculta la sección de selección de métodos y el botón general
                    document.getElementById('payment-methods-selection').classList.add('hidden');
                } else if (selectedMethod === 'card') {
                    cardDetailsSection.classList.remove('hidden');
                    document.getElementById('payment-methods-selection').classList.add('hidden');
                }
            });

            // Nota: En una aplicación real, aquí también tendrías que obtener el total
            // del carrito y pasarlo a las secciones de pago.
            // Ejemplo: const totalFromCart = "$123.45";
            // document.querySelectorAll('.final-amount').forEach(el => el.textContent = totalFromCart);
        });
    </script>
</body>
</html>
