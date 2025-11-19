<?php
// ********* CARGA EL CONTROLADOR QUE PREPARA LOS DATOS *********
require_once('../controlador/checkoutController.php'); 
// Ahora, tu HTML/CSS/JS puede usar las variables $carrito, $total_final, etc.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métodos de Pago - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
    <link rel="stylesheet" href="menu.css"> 
    <link rel="stylesheet" href="payment.css"> 
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        /* Estilo para las secciones de detalle ocultas */
        .payment-details-section.hidden {
            display: none;
        }
        /* Estilo para la confirmación de pedido */
        .confirmation-box {
            background-color: #e6ffe6;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            margin-top: 40px;
        }
        .confirmation-box h3 {
            color: #3c763d;
        }
        .confirmation-box p {
            font-size: 1.1em;
        }
        .confirmation-box a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        /* Estilo para resaltar error en el input (usado en JS) */
        .card-input.error {
            border: 2px solid red !important;
        }
    </style>
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
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="menu.php">Menú</a></li>
                <li class="active-menu-link"><a href="cart.php">Carrito</a></li> 
            </ul>
        </nav>
        <button id="user-button" class="user-active" onclick="window.location.href='Perfil.php'"><?php echo htmlspecialchars($nombre_usuario); ?></button>
    </header>

    <main class="payment-main">
        
        <section id="payment-methods-selection">
            <h2>Selecciona tu método de pago</h2>
            
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
                <span class="final-amount">$0.00</span>
            </div>

            <button class="confirm-payment-button" id="submit-cash-payment" data-method="cash">
                Confirmar Pedido con Pago en Efectivo
            </button>
        </section>

        <section id="card-payment-details" class="payment-details-section hidden">
            <h2>Pago con tarjeta</h2>
            
            <form id="card-form">
                <div class="card-form-grid">
                    <div class="input-label">Número de tarjeta</div>
                    <input type="text" id="card-number" placeholder="XXXX XXXX XXXX XXXX" class="card-input" required maxlength="19"> 

                    <div class="input-label">Nombre del titular</div>
                    <input type="text" id="card-holder" placeholder="Nombre completo" class="card-input" required>
                    
                    <div class="input-label small-label">Vencimiento</div>
                    <input type="text" id="card-expiry" placeholder="MM/AA" class="card-input small-input" required maxlength="5"> 

                    <div class="input-label small-label">Código de seguridad</div>
                    <input type="text" id="card-cvv" placeholder="CVV" class="card-input small-input" maxlength="4" required> 
                </div>

                <div class="payment-total">
                    <span>Total a pagar:</span>
                    <span class="final-amount">$0.00</span>
                </div>

                <button class="pay-now-button" type="submit" data-method="card">
                    Pagar ahora
                </button>
            </form>
        </section>

        <section id="order-confirmation" class="payment-details-section hidden">
            <div class="confirmation-box">
                <h3>¡Pedido Confirmado con Éxito! 🎉</h3>
                <p>Tu orden ha sido enviada a la cocina.</p>
                <p>Número de Orden: <strong id="order-number"></strong></p>
                <p>Total: <strong id="final-total"></strong></p>
                <p>¡Gracias por tu compra en Taquería El Gallo Giro!</p>
                <a href="inicio.php">Volver al Inicio</a>
            </div>
        </section>
        
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... (TUS CONSTANTES Y VARIABLES EXISTENTES DEBEN ESTAR AQUÍ) ...
            const modalSection = document.getElementById('payment-methods-selection');
            const optionCash = document.getElementById('option-cash');
            const optionCard = document.getElementById('option-card');
            const confirmMethodButton = document.getElementById('confirm-method-button');
            
            const cashDetailsSection = document.getElementById('cash-payment-details');
            const cardDetailsSection = document.getElementById('card-payment-details');
            const confirmationSection = document.getElementById('order-confirmation');

            // Inputs de Tarjeta
            const cardNumberInput = document.getElementById('card-number');
            const cardExpiryInput = document.getElementById('card-expiry');
            const cardCvvInput = document.getElementById('card-cvv');
            const cardForm = document.getElementById('card-form');
            
            // Botones de pago final
            // ...
// Botones de pago final (USANDO LOS ID REALES/NUEVOS)
const cashConfirmButton = document.getElementById('submit-cash-payment'); //CORREGIDO: Usando el nuevo ID
const cardPayButton = document.querySelector('.pay-now-button'); // CORREGIDO: El de tarjeta usa type="submit" en un form. Lo obtenemos por clase.
// ...

            let selectedMethod = null;
            
            // ********** VARIABLES DE CONTROL **********
            const TOTAL_FINAL = parseFloat('<?php echo $total_final_js; ?>'); 
            const API_PEDIDO_URL = '../modelo/conexion/ApiPedidos.php'; 

            // ----------------------------------------------------
            // I. LÓGICA AJAX CENTRAL: ENVÍO DEL PEDIDO (MODIFICADA PARA DEBUG)
            // ----------------------------------------------------
            function handleOrderSubmission(paymentMethod) {
                if (TOTAL_FINAL <= 0) {
                    alert('El total del pedido debe ser mayor a $0.00 para pagar.');
                    return;
                }
                
                // Deshabilitar botones para evitar doble envío
                if (cashConfirmButton) cashConfirmButton.disabled = true;
                if (cardPayButton) cardPayButton.disabled = true;
                
                const postData = {
                    action: 'process_order',
                    total: TOTAL_FINAL.toFixed(2), 
                    metodo_pago: paymentMethod
                };

                $.ajax({
                    url: API_PEDIDO_URL,
                    type: 'POST',
                    dataType: 'json',
                    data: postData,
                    success: function(response) {
                        if (response.success) {
                            // Éxito: El pedido se guardó y el carrito se limpió en el servidor
                            showConfirmation(paymentMethod, response.order_id); 
                        } else {
                            // Fallo de Lógica de Negocio/DB (el PHP respondió con 'success: false')
                            alert(' Fallo de lógica al procesar el pedido. El servidor respondió: ' + response.message);
                            console.error('Error del servidor:', response);
                            if (cashConfirmButton) cashConfirmButton.disabled = false;
                            if (cardPayButton) cardPayButton.disabled = false;
                        }
                    },
                    error: function(xhr, status, error) {
                        // Fallo de Conexión/Servidor/Error Fatal de PHP (El script crasheó)
                        console.error(' AJAX Error Status:', status);
                        console.error(' AJAX Response Text (Error de PHP):', xhr.responseText);
                        
                        // Muestra el error de PHP directamente en una alerta
                        let errorMessage = ' ERROR FATAL DE PHP. La orden NO se guardó.\n\n';
                        if (xhr.status === 0) {
                            errorMessage += 'El archivo API_PEDIDO_URL es incorrecto: ' + API_PEDIDO_URL + ' (o el servidor no responde).';
                        } else if (xhr.responseText.includes('Fatal error')) {
                            // Recorta el error para que sea legible
                            let phpError = xhr.responseText.substring(xhr.responseText.indexOf('Fatal error'), xhr.responseText.indexOf('<br')).trim();
                            errorMessage += 'Detalle del error de PHP:\n' + phpError;
                        } else {
                            errorMessage += 'Respuesta completa:\n' + xhr.responseText.substring(0, 300) + '...';
                        }
                        
                        alert(errorMessage);
                        
                        // Re-habilitar botones
                        if (cashConfirmButton) cashConfirmButton.disabled = false;
                        if (cardPayButton) cardPayButton.disabled = false;
                    }
                });
            }


            // ----------------------------------------------------
            // II. LÓGICA DE NAVEGACIÓN Y CONFIRMACIÓN (ACTUALIZADA)
            // ----------------------------------------------------

            let finalOrderTotal = TOTAL_FINAL; 

            function initializeCheckout() {
                if (isNaN(finalOrderTotal) || finalOrderTotal <= 0) {
                     alert("Tu carrito está vacío o hubo un error al cargar el total. Volviendo al carrito.");
                     window.location.href = 'cart.php';
                     return;
                }
                const formattedTotal = `$${finalOrderTotal.toFixed(2)}`;
                document.querySelectorAll('.final-amount').forEach(el => el.textContent = formattedTotal);
                hideAllPaymentDetails();
                modalSection.classList.remove('hidden');
            }


            function hideAllPaymentDetails() {
                modalSection.classList.add('hidden');
                cashDetailsSection.classList.add('hidden');
                cardDetailsSection.classList.add('hidden');
                confirmationSection.classList.add('hidden');
            }
            
            function showConfirmation(method, orderId) { 
                hideAllPaymentDetails();
                
                document.getElementById('order-number').textContent = `#${orderId}`; 
                document.getElementById('final-total').textContent = `$${finalOrderTotal.toFixed(2)} (${method})`;
                
                confirmationSection.classList.remove('hidden');
            }
            
            // --- MANEJO DE SELECCIÓN DE MÉTODO (CASH/CARD) ---
            
            function handleOptionClick(method, cardElement) {
                document.querySelectorAll('.payment-option-card').forEach(card => {
                    card.classList.remove('active');
                });
                cardElement.classList.add('active');
                selectedMethod = method;
                confirmMethodButton.style.display = 'block'; 
            }

            optionCash.addEventListener('click', () => handleOptionClick('cash', optionCash));
            optionCard.addEventListener('click', () => handleOptionClick('card', optionCard));

            confirmMethodButton.addEventListener('click', function() {
                modalSection.classList.add('hidden'); 
                
                if (selectedMethod === 'cash') {
                    cashDetailsSection.classList.remove('hidden');
                } else if (selectedMethod === 'card') {
                    cardDetailsSection.classList.remove('hidden');
                }
            });

            // Flujo de Pago en Efectivo (EVENTO ACTUALIZADO)
            if (cashConfirmButton) {
                cashConfirmButton.addEventListener('click', function() {
                    handleOrderSubmission('Efectivo');
                });
            }


            // ----------------------------------------------------
            // III. FUNCIONES DE VALIDACIÓN DE TARJETA (EXISTENTES)
            // ----------------------------------------------------

            function validateLuhn(cardNumber) {
                let cleanedCardNumber = cardNumber.replace(/\s/g, '').replace(/\D/g, ''); 
                if (!/^\d{13,19}$/.test(cleanedCardNumber)) return false;

                let sum = 0;
                let double = false;
                
                for (let i = cleanedCardNumber.length - 1; i >= 0; i--) {
                    let digit = parseInt(cleanedCardNumber.charAt(i), 10);

                    if (double) {
                        digit *= 2;
                        if (digit > 9) digit -= 9; 
                    }
                    sum += digit;
                    double = !double;
                }
                return (sum % 10 === 0);
            }

            function validateExpiry(expiry) {
                const parts = expiry.split('/');
                if (parts.length !== 2) return false;

                const month = parseInt(parts[0], 10);
                const year = parseInt(parts[1], 10);
                
                if (isNaN(month) || isNaN(year) || month < 1 || month > 12) return false;

                const now = new Date();
                const currentYear = now.getFullYear() % 100;
                const currentMonth = now.getMonth() + 1;

                if (year < currentYear) return false;
                
                if (year === currentYear && month < currentMonth) return false;

                return true;
            }

            function validateCvv(cvv) {
                return /^\d{3,4}$/.test(cvv);
            }


            // ----------------------------------------------------
            // IV. MANEJO DEL FORMULARIO DE TARJETA (ACTUALIZADO)
            // ----------------------------------------------------
            
            if (cardForm) {
                cardForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const cardNumber = cardNumberInput.value;
                    const cardExpiry = cardExpiryInput.value;
                    const cardCvv = cardCvvInput.value;
                    let isValid = true;
                    let errorMessage = 'Por favor, corrige los siguientes errores:\n\n';

                    // 1. Limpiar estilos de error previos
                    [cardNumberInput, cardExpiryInput, cardCvvInput].forEach(input => {
                        input.classList.remove('error');
                    });

                    // 2. Validar campos
                    if (!validateLuhn(cardNumber)) {
                        isValid = false;
                        errorMessage += '• El número de tarjeta no es válido (o formato incorrecto).\n';
                        cardNumberInput.classList.add('error');
                    }
                    
                    if (!validateExpiry(cardExpiry)) {
                        isValid = false;
                        errorMessage += '• La fecha de vencimiento (MM/AA) no es válida o está caducada.\n';
                        cardExpiryInput.classList.add('error');
                    }
                    
                    if (!validateCvv(cardCvv)) {
                        isValid = false;
                        errorMessage += '• El CVV debe tener 3 o 4 dígitos numéricos.\n';
                        cardCvvInput.classList.add('error');
                    }

                    // 3. Resultado (LLAMADA AJAX)
                    if (isValid) {
                        alert("Tarjeta validada correctamente. ¡Procesando pago!");
                        handleOrderSubmission('Tarjeta'); 
                    } else {
                        alert(errorMessage);
                    }
                });
            }


            // ----------------------------------------------------
            // V. MEJORAS DE UX (EXISTENTES)
            // ----------------------------------------------------

            // Formato de Número de Tarjeta (4444 4444 4444 4444)
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    const value = e.target.value.replace(/\s/g, '').replace(/\D/g, ''); 
                    e.target.value = value.match(/.{1,4}/g)?.join(' ') || ''; 
                });
            }
            
            // Formato de Vencimiento (MM/AA)
            if (cardExpiryInput) {
                cardExpiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); 
                    if (value.length > 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }


            // --- INICIALIZACIÓN FINAL ---
            initializeCheckout();

        });
    </script>
</body>
</html>