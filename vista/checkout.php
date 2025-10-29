<?php
// vista/checkout.php
session_start();

// ********** 1. RUTA CORREGIDA DE CONEXIÓN **********
// La ruta sube un nivel (de 'vista' a 'IntegradorWeb'), entra a 'modelo' y luego a 'conexion'.
require_once('../modelo/conexion/Conexion.php');

// ********** 2. CÁLCULO DE LA ORDEN EN PHP **********
$carrito = $_SESSION['carrito'] ?? [];
$nombre_usuario = $_SESSION['usuario']['nombre'] ?? 'Usuario'; // Asume que el nombre del usuario está en $_SESSION['usuario']['nombre']
$total_subtotal = 0.00;
$SHIPPING_COST = 0.00; // Define el costo de envío si lo tienes

// Calcular el total
foreach ($carrito as $item) {
    // Aseguramos que el subtotal es numérico antes de sumarlo
    $subtotal = is_numeric($item['subtotal']) ? (float)$item['subtotal'] : 0.00;
    $total_subtotal += $subtotal;
}

$total_final = $total_subtotal + $SHIPPING_COST;

// Formato para pasar a JavaScript (usando punto como separador decimal)
$total_final_js = number_format($total_final, 2, '.', '');
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
                <li><a href="index.php">Inicio</a></li>
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

            <button class="confirm-payment-button" data-method="cash">
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
                <a href="index.php">Volver al Inicio</a>
            </div>
        </section>
        
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            let selectedMethod = null;
            
            // ********** VARIABLE RECIBIDA DESDE PHP **********
            // Ahora la variable se inicializa con el total calculado en el servidor.
            let finalOrderTotal = parseFloat(<?php echo $total_final_js; ?>); 

            // ----------------------------------------------------
            // I. LÓGICA DE LA ORDEN Y NAVEGACIÓN
            // ----------------------------------------------------

            function initializeCheckout() {
                // Si el total es 0 o NaN (por un carrito vacío), redirigir o mostrar un error
                if (isNaN(finalOrderTotal) || finalOrderTotal <= 0) {
                     alert("Tu carrito está vacío o hubo un error al cargar el total. Volviendo al carrito.");
                     window.location.href = 'cart.php';
                     return;
                }
                
                // Actualizar los totales mostrados en las secciones de pago
                const formattedTotal = `$${finalOrderTotal.toFixed(2)}`;
                document.querySelectorAll('.final-amount').forEach(el => el.textContent = formattedTotal);
                
                // Mostrar la selección de métodos
                hideAllPaymentDetails();
                modalSection.classList.remove('hidden');
            }


            function hideAllPaymentDetails() {
                modalSection.classList.add('hidden');
                cashDetailsSection.classList.add('hidden');
                cardDetailsSection.classList.add('hidden');
                confirmationSection.classList.add('hidden');
            }
            
            function showConfirmation(method) {
                hideAllPaymentDetails();
                
                const orderNumber = Math.floor(Math.random() * 100000) + 1000;

                document.getElementById('order-number').textContent = `#${orderNumber}`;
                document.getElementById('final-total').textContent = `$${finalOrderTotal.toFixed(2)} (${method})`;
                
                // ** LÓGICA CLAVE DE LIMPIEZA **
                // Aquí deberías hacer una llamada AJAX a un script PHP (ej: procesar_pago.php)
                // para guardar la orden en la BD y limpiar el $_SESSION['carrito'] en el servidor.
                // localStorage.removeItem('tempCheckoutData'); // Ya no usamos localStorage
                
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

            // Flujo de Pago en Efectivo
            document.querySelector('.confirm-payment-button[data-method="cash"]').addEventListener('click', function() {
                // Aquí se haría la llamada AJAX para guardar la orden como "Pendiente de pago"
                showConfirmation('Efectivo');
            });


            // ----------------------------------------------------
            // II. FUNCIONES DE VALIDACIÓN DE TARJETA (EXISTENTES)
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
            // III. MANEJO DEL FORMULARIO DE TARJETA (EXISTENTE)
            // ----------------------------------------------------
            
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

                // 3. Resultado
                if (isValid) {
                    alert("Tarjeta validada correctamente. ¡Procesando pago!");
                    // Simulación de pago exitoso (Aquí iría la llamada AJAX a un API de pago real)
                    showConfirmation('Tarjeta');
                } else {
                    alert(errorMessage);
                }
            });


            // ----------------------------------------------------
            // IV. MEJORAS DE UX (EXISTENTES)
            // ----------------------------------------------------

            // Formato de Número de Tarjeta (4444 4444 4444 4444)
            cardNumberInput.addEventListener('input', function(e) {
                const value = e.target.value.replace(/\s/g, '').replace(/\D/g, ''); // Quita espacios y no dígitos
                e.target.value = value.match(/.{1,4}/g)?.join(' ') || ''; // Agrega espacios
            });
            
            // Formato de Vencimiento (MM/AA)
            cardExpiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Quita caracteres no numéricos
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                e.target.value = value;
            });


            // --- INICIALIZACIÓN FINAL ---
            initializeCheckout();

            document.getElementById('cerrarSesion').addEventListener('click', function() {
                alert("Gracias por su compra. ¡Vuelva pronto!");
            });

        });
    </script>
</body>
</html>