<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Tortas - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css"> 
    </head>
<body>
    <?php session_start(); // CRÍTICO: Iniciar sesión para mantener el carrito activo ?>
    
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
                <li><a href="cart.php">Carrito</a></li>
            </ul>
        </nav>
        <button id="user-button" class="user-active" onclick="window.location.href='Perfil.php'">Perfil</button>
    </header>

    <main class="menu-main">
        <section id="menu-grid-section">
            <h2>Menú de Tortas</h2>
            
            <div class="dishes-grid menu-tortas-grid" id="tortasContainer">
                </div>
        </section>
    </main>
    
    <div id="complements-modal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            
            <div class="modal-body">
                <div class="modal-product-image">
                    <img id="modal-image" src="../assets/css/tacosalpastor.png" alt="Producto">
                </div>
                
                <div class="modal-product-details">
                    <h3 id="modal-product-name">Nombre del Producto</h3>
                    <p class="complement-label">Complementos adicionales</p>
                    
                    <div class="complement-options" id="complementos-contenedor">
                        </div>

                    <div class="modal-footer-controls">
                        <span class="product-price-modal" id="modal-product-price-display">$0.00 c/u</span> 
                        
                        <div class="quantity-control">
                            <button class="quantity-button minus" id="modal-minus-button">-</button>
                            <span class="quantity-display" id="modal-quantity-display">1</span>
                            <button class="quantity-button plus" id="modal-plus-button">+</button>
                        </div>
                        
                        <button class="add-to-cart-modal-button" id="addToCartModalButton" data-product-id="" data-product-price="">
                            <img src="../assets/css/carrito.png" alt="Añadir">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // ----------------------------------------------------
            // 1. SELECTORES DE ELEMENTOS Y VARIABLES GLOBALES
            // ----------------------------------------------------
            const modal = document.getElementById('complements-modal');
            const closeButton = modal.querySelector('.close-button');
            const modalImage = document.getElementById('modal-image');
            const modalName = document.getElementById('modal-product-name');
            const modalPriceDisplay = document.getElementById('modal-product-price-display');
            const addToCartModalButton = document.getElementById('addToCartModalButton');
            const quantityDisplay = document.getElementById('modal-quantity-display');
            const minusButton = document.getElementById('modal-minus-button');
            const plusButton = document.getElementById('modal-plus-button');
            const complementosContenedor = document.getElementById('complementos-contenedor');

            let productosCargados = []; 
            const contenedor = document.getElementById('tortasContainer');
            // Rutas relativas
            const apiUrl = 'http://localhost/IntegradorWeb/modelo/conexion/ApiProductos.php?api=listar';
            const ingredientesApiUrl = 'http://localhost/IntegradorWeb/modelo/conexion/ApiIngredientes.php?api=listarTortas';
            const AJAX_CART_URL = '../controlador/procesar_carrito.php';
            let modificadoresDisponibles = [];
            const CATEGORIA_ID = 2; 

            // ----------------------------------------------------
            // 2. LÓGICA DE MODAL Y CANTIDAD (+/-)
            // ----------------------------------------------------
            function closeModal() {
                 modal.style.display = 'none';
                 quantityDisplay.textContent = '1';
                 complementosContenedor.querySelectorAll('.active-complement').forEach(btn => {
                    btn.classList.remove('active-complement');
                 });
            }
            
            function updateModalPrice(cantidad) {
                const unitPrice = parseFloat(addToCartModalButton.getAttribute('data-product-price') || 0);
                const newTotal = unitPrice * cantidad;
                modalPriceDisplay.textContent = `$${newTotal.toFixed(2)} Total`; 
            }

            minusButton.addEventListener('click', () => {
                let currentQuantity = parseInt(quantityDisplay.textContent);
                if (currentQuantity > 1) {
                    quantityDisplay.textContent = currentQuantity - 1;
                    updateModalPrice(currentQuantity - 1); 
                }
            });

            plusButton.addEventListener('click', () => {
                let currentQuantity = parseInt(quantityDisplay.textContent);
                quantityDisplay.textContent = currentQuantity + 1;
                updateModalPrice(currentQuantity + 1);
            });


            // --- FUNCIÓN CENTRAL: ABRIR MODAL ---
            function openModal(productId) {
                const producto = productosCargados.find(p => p.idProductos == productId); 

                if (producto) {
                    modalImage.src = (producto.imagen === null || producto.imagen === '') ? "../assets/css/tacosalpastor.png" : producto.imagen;
                    modalName.textContent = producto.nombre;
                    
                    addToCartModalButton.setAttribute('data-product-id', producto.idProductos);
                    addToCartModalButton.setAttribute('data-product-price', parseFloat(producto.precio).toFixed(2));

                    quantityDisplay.textContent = '1';
                    updateModalPrice(1);
                    
                    modal.style.display = 'block';
                } else {
                    console.error(`Producto con ID ${productId} no encontrado en datos cargados.`);
                }
            }
            
            // ----------------------------------------------------
            // 3. LÓGICA DE AGREGAR AL CARRITO (AJAX) 
            // ----------------------------------------------------
            addToCartModalButton.addEventListener('click', () => {
                const productId = addToCartModalButton.getAttribute('data-product-id'); 
                const productPrice = addToCartModalButton.getAttribute('data-product-price'); 
                const productName = modalName.textContent; 
                const cantidad = parseInt(quantityDisplay.textContent);
                
                if (cantidad < 1 || !productId || !productPrice) {
                    alert("Por favor, selecciona una cantidad válida y un producto.");
                    return;
                }

                const modificadoresSeleccionados = [];
                complementosContenedor.querySelectorAll('.active-complement').forEach(btn => {
                    const modName = btn.getAttribute('data-mod-name'); 
                    const modData = modificadoresDisponibles.find(m => m.nombre === modName); 
                    
                    if (modData) {
                        modificadoresSeleccionados.push({
                            nombre: modData.nombre,
                            precio_extra: 0.00, 
                            idIngrediente: modData.idIngrediente,
                            categoria: modData.categoria
                        });
                    }
                });

                const ajaxData = {
                    action: 'add',
                    producto_id: productId,        
                    nombre: productName,           
                    precio_base: productPrice,     
                    cantidad: cantidad,
                    modificadores_json: JSON.stringify(modificadoresSeleccionados) 
                };

                $.ajax({
                    url: AJAX_CART_URL, 
                    type: 'POST',
                    dataType: 'json', 
                    data: ajaxData, 
                    success: function(response) {
                        if (response.success) {
                            alert(" ¡Agregado al Carrito! " + productName + " x " + cantidad); 
                            closeModal();
                        } else {
                             alert(" Error al añadir: " + response.message);
                             console.error("Server Error Response:", response);
                        }
                    },
                    error: function(xhr) {
                         alert(" Error de comunicación con el servidor al actualizar el carrito.");
                         console.error("AJAX Error:", xhr.responseText);
                    }
                });
            });
            
            // ----------------------------------------------------
            // 4. LÓGICA DE CARGA DE PRODUCTOS DEL MENÚ (UNIFICADA CON TACOS)
            // ----------------------------------------------------
            async function cargarProductos() {
                contenedor.innerHTML = ''; 

                try {
                    const respuesta = await fetch(apiUrl); 
                    
                    if (!respuesta.ok) {
                        throw new Error(`Error HTTP! Estado: ${respuesta.status}`);
                    }

                    const data = await respuesta.json();
                    const todosLosProductos = data.contenido; 
                    
                    productosCargados = todosLosProductos; 
                    
                    const productosParaMostrar = todosLosProductos.filter(producto => producto.categoria == CATEGORIA_ID); 

                    if (productosParaMostrar.length === 0) {
                         contenedor.innerHTML = `<p class="info-message">No hay productos disponibles en este momento.</p>`;
                         return;
                    }
                    
                    productosParaMostrar.forEach(producto => {
                        const dishCard = document.createElement('div');
                        dishCard.classList.add('dish-card', 'menu-card');

                        dishCard.innerHTML = `
                            <div class="card-image-container">
                                <img src="${producto.imagen || "../assets/css/tacosalpastor.png"}" alt="${producto.nombre}">
                            </div>
                            <h3>${producto.nombre}</h3>
                            <p class="price">$${parseFloat(producto.precio).toFixed(2)} c/u</p>
                            <button class="add-to-cart-button open-modal" data-product-id="${producto.idProductos}">
                                <img src="../assets/css/carrito.png" alt="Agregar">
                            </button>
                        `;

                        dishCard.querySelector('.add-to-cart-button').addEventListener('click', (e) => {
                             const productId = e.currentTarget.getAttribute('data-product-id');
                             openModal(productId);
                        });

                        contenedor.appendChild(dishCard);
                    });

                } catch (error) {
                    console.error('Error al cargar los productos:', error); 
                    contenedor.innerHTML = `<p class="error-message">Error al cargar los productos. Por favor, revisa la consola para más detalles.</p>`; 
                }
            }
            
            // ----------------------------------------------------
            // 5. LÓGICA DE CARGA DE COMPLEMENTOS (UNIFICADA CON TACOS)
            // ----------------------------------------------------
            async function cargarComplementos() {
                try {
                    const response = await fetch(ingredientesApiUrl);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    
                    complementosContenedor.innerHTML = ''; 
                    modificadoresDisponibles = data.contenido || []; 

                    if (modificadoresDisponibles.length > 0) {
                        modificadoresDisponibles.forEach(complemento => {
                            const complementButton = document.createElement('button');
                            complementButton.classList.add('complement-button');
                            complementButton.textContent = complemento.nombre;
                            complementButton.setAttribute('data-mod-name', complemento.nombre);

                            complementButton.addEventListener('click', function() {
                                this.classList.toggle('active-complement');
                            });

                            complementosContenedor.appendChild(complementButton);
                        });
                    } else {
                        complementosContenedor.innerHTML = `<p style="font-size: 0.9em; color: #555;">No hay complementos disponibles.</p>`;
                    }

                } catch(error) {
                    console.error('Error al cargar los complementos:', error);
                    complementosContenedor.innerHTML = `<p class="error-message">Error al cargar complementos.</p>`;
                }
            }


            // --- Ejecución y Cierre del Modal ---
            cargarProductos();
            cargarComplementos();
            
            closeButton.addEventListener('click', closeModal);
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>