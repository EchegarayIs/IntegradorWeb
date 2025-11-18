<?php
// vista/Cart.php
require_once('../modelo/CartModel.php');

// 1. Instanciar el Modelo para obtener la data
$cart = new CartModel();
$carrito = $cart->getItems(); 
$total_subtotal = $cart->getTotalSubtotal(); // El Modelo calcula el subtotal por ti
$SHIPPING_COST = 0.00; // Puedes definir esto en el Modelo si quieres
$total_final = $total_subtotal + $SHIPPING_COST;

// Variable de control para el botón de pago
$is_cart_empty = $cart->isEmpty(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
    <link rel="stylesheet" href="menu.css"> 
    <link rel="stylesheet" href="cart.css"> 
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
                    <a href="index.php">Menú</a>
                    <div class="despliegue-content">
                        <a href="Tacos.php">Tacos</a>
                        <a href="Tortas.php">Tortas</a>
                        <a href="Bebidas.php">Bebidas</a>
                    </div>
                </li>
                <li class="active-menu-link"><a href="#">Carrito</a></li>
            </ul>
        </nav>
        <button id="user-button" class="user-active" onclick="window.location.href='Perfil.php'">Perfil</button>
    </header>

    <main class="cart-main">
        <section id="cart-content">
            <div class="cart-grid">
                
                <div class="cart-items-container">
                    <h2>Tu pedido</h2>

                    <?php if ($is_cart_empty): ?>
                        <p id="empty-cart-message" class="empty-cart-message">El carrito está vacío. ¡Añade productos del menú!</p>
                    <?php else: ?>
                        <p id="empty-cart-message" style="display:none;"></p>
                    <?php endif; ?>
                    
                    <?php 
                    foreach ($carrito as $item_hash => $item): // <-- ¡Usando el Hash Único!
                    ?>
                    
                    <div class="cart-item-card" data-product-id="<?php echo $item_hash; ?>">
                        <div class="item-details">
                            <div class="item-image-container">
                                <img src="../assets/css/tacosalpastor.png" alt="<?php echo htmlspecialchars($item['nombre']); ?>">
                            </div>
                            <span class="item-name"><?php echo htmlspecialchars($item['nombre']); ?></span>
                            <br><br>
                            <?php if (!empty($item['modificadores'])): ?>
                                <ul class="item-mods-list">
                                    <?php foreach ($item['modificadores'] as $mod): ?>
                                        <li class="mod-item">
                                            <?php echo htmlspecialchars($mod['nombre']); ?> 
                                            <?php if ($mod['precio_extra'] > 0): ?>
                                                (<span class="mod-price">+$<?php echo number_format($mod['precio_extra'], 2); ?></span>)
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <span class="no-mods"> (Sin modificaciones)</span>
                            <?php endif; ?>
                            <span class="item-unit-price" data-unit-price="<?php echo number_format($item['precio'], 2, '.', ''); ?>" style="display:none;"></span>
                        </div>
                        
                        <span class="item-price" id="subtotal-<?php echo $item_hash; ?>">$<?php echo number_format($item['subtotal'], 2); ?></span> 
                        
                        <div class="item-controls">
                            <div class="quantity-control small-control">
                                <button class="quantity-button minus" data-action="decrement" data-id="<?php echo $item_hash; ?>">-</button>
                                <span class="quantity-display" id="quantity-<?php echo $item_hash; ?>"><?php echo $item['cantidad']; ?></span>
                                <button class="quantity-button plus" data-action="increment" data-id="<?php echo $item_hash; ?>">+</button>
                            </div>
                            <button class="remove-item-button" data-action="remove" data-id="<?php echo $item_hash; ?>">
                                <img src="../assets/css/botebasura.png" alt="Eliminar"> 
                            </button>
                        </div>
                    </div>

                    <?php endforeach; ?>
                    </div><div class="ticket-container">
                    <h3>Ticket de compra</h3>
                    <div class="summary-line">
                        <span>Subtotal:</span>
                        <span id="summary-subtotal" class="summary-value">$<?php echo number_format($total_subtotal, 2); ?></span>
                    </div>
                    <div class="summary-line">
                        <span>Costo de Servicio/Envío:</span>
                        <span id="summary-shipping" class="summary-value"><?php echo ($SHIPPING_COST > 0) ? '$' . number_format($SHIPPING_COST, 2) : 'Gratis'; ?></span>
                    </div>
                    <hr class="summary-divider">
                    <div class="summary-line total-line">
                        <span>Total:</span>
                        <span id="summary-total" class="summary-value">$<?php echo number_format($total_final, 2); ?></span>
                    </div>
                    <div class="final-price" id="final-price-display">
                        $<?php echo number_format($total_final, 2); ?>
                    </div>

                    <button class="checkout-button" onclick="finalizarPedido()" <?php echo $is_cart_empty ? 'disabled' : ''; ?> id="checkout-button-main">
                        Proceder al pago
                    </button>
                </div>
            </div>
        </section>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    
    <script>
        // RUTA AJAX MANTENIDA
        const CAR_AJAX_URL = '../controlador/procesar_carrito.php'; 
        const SHIPPING_COST = <?php echo $SHIPPING_COST; ?>;

        // -------------------------------------------------------------
        // 1. FUNCIONES DE ACTUALIZACIÓN VISUAL DEL RESUMEN
        // -------------------------------------------------------------
        // Esta función ahora confía únicamente en el 'total_carrito' que le manda el servidor (Controlador/Modelo)
        function updateSummaryDisplay(newTotal) {
            const subtotal = parseFloat(newTotal);
            const total = subtotal + SHIPPING_COST;
            
            $('#summary-subtotal').text(`$${subtotal.toFixed(2)}`);
            $('#summary-total').text(`$${total.toFixed(2)}`);
            $('#final-price-display').text(`$${total.toFixed(2)}`);
            
            if (subtotal <= 0) {
                $('#checkout-button-main').prop('disabled', true);
                $('#empty-cart-message').show().text('El carrito está vacío. ¡Añade productos del menú!');
                $('.cart-items-container').find('.cart-item-card').remove();
            } else {
                $('#checkout-button-main').prop('disabled', false);
                $('#empty-cart-message').hide();
            }
        }

        // -------------------------------------------------------------
        // 2. FUNCIÓN AJAX PARA ACTUALIZAR O ELIMINAR
        // -------------------------------------------------------------
        function updateCartItem(itemHash, quantity, action) { // <-- Usa itemHash como ID
            
            const cardElement = $(`.cart-item-card[data-product-id="${itemHash}"]`);
            
            if (action === 'update' && quantity === 0) {
                action = 'remove';
            }
            
            $.ajax({
                url: CAR_AJAX_URL,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: action, 
                    id: itemHash, // <-- Enviamos el hash al Controlador
                    cantidad: quantity 
                },
                success: function(response) {
                    if (response.success) {
                        
                        if (action === 'remove') {
                            cardElement.remove();
                            // Puedes quitar el alert si es un TPV de uso constante
                            alert(" Producto eliminado correctamente."); 
                        } 
                        
                        else if (action === 'update') {
                            $(`#quantity-${itemHash}`).text(quantity);
                            
                        }
                        
                        updateSummaryDisplay(response.total_carrito);
                        
                    } else {
                        alert(` Error en la operación: ${response.message}`);
                    }
                },
                error: function(xhr) {
                    alert(" Error de comunicación con el servidor al actualizar el carrito.");
                    console.error("AJAX Error:", xhr.responseText);
                }
            });
        }

        // -------------------------------------------------------------
        // 3. MANEJO DE EVENTOS DEL DOM
        // -------------------------------------------------------------
        $(document).ready(function() {
            
            $('.cart-items-container').on('click', 'button', function() {
                const button = $(this);
                const itemHash = button.data('id'); // <-- Usamos el hash como ID
                const action = button.data('action');
                
                const quantityDisplay = $(`#quantity-${itemHash}`);
                let currentQuantity = parseInt(quantityDisplay.text());

                if (action === 'remove') {
                    const itemName = button.closest('.cart-item-card').find('.item-name').text();
                    if (confirm(`¿Estás seguro de que quieres eliminar "${itemName}"?`)) {
                        updateCartItem(itemHash, 0, 'remove'); 
                    }
                    return;
                }
                
                let newQuantity = currentQuantity;
                if (action === 'increment') {
                    newQuantity = currentQuantity + 1;
                } else if (action === 'decrement' && currentQuantity > 0) {
                    newQuantity = currentQuantity - 1;
                }

                if (newQuantity !== currentQuantity) {
                    updateCartItem(itemHash, newQuantity, 'update');
                }
            });

        });
        
        function finalizarPedido() {
            window.location.href = 'checkout.php';
        }
    </script>
</body>
</html>