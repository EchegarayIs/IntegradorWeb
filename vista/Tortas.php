<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Tortas - Taquería El Gallo Giro</title>
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
            <ul >
                <li><a href="index.php" class="active">Inicio</a></li>
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
                
            <!-- Los productos se cargarán aquí dinámicamente -->
                
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
                    
                    <div class="complement-options" id="complementos-contenedor">
                        
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
            const mone = document.querySelector('.product-price-modal');

            if (minusButton && plusButton && quantityDisplay) {
                minusButton.addEventListener('click', () => {
                    let currentQuantity = parseInt(quantityDisplay.textContent);
                    if (currentQuantity > 1) {
                        quantityDisplay.textContent = currentQuantity - 1;
                        let op = (parseFloat(mone.textContent.replace('$','').replace(' c/u','')) / (currentQuantity)).toFixed(2)
                        mone.textContent = `$${(parseFloat(op.replace('$','').replace(' c/u','')) * (currentQuantity - 1)).toFixed(2)}`;
                    }
                });

                plusButton.addEventListener('click', () => {
                    let currentQuantity = parseInt(quantityDisplay.textContent);
                    quantityDisplay.textContent = currentQuantity + 1;
                    let op = (parseFloat(mone.textContent.replace('$','').replace(' c/u','')) / (currentQuantity)).toFixed(2)
                    mone.textContent = `$${(parseFloat(op.replace('$','').replace(' c/u','')) * (currentQuantity + 1)).toFixed(2)}`;
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
        document.addEventListener('DOMContentLoaded', function() {
        // Cargar complementos desde la base de datos
        function cargarComplementos() {
            fetch(`http://localhost/IntegradorWeb/modelo/conexion/ApiIngredientes.php?api=listarTortas`)
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

    
    // Código para cargar los tacos desde la API
    // --- Selectores del DOM ---
    const contenedor = document.getElementById('tortasContainer');
    const apiUrl = 'http://localhost/IntegradorWeb/modelo/conexion/ApiProductos.php?api=listar';


    // Selectores del Modal (se mantienen del código anterior para la interacción)
    const modal = document.getElementById('complements-modal');
    const closeButton = modal.querySelector('.close-button');
    const modalImage = modal.querySelector('.modal-product-image img');
    const modalName = modal.querySelector('.modal-product-details h3');
    const modalPrice = modal.querySelector('.product-price-modal');
    const addToCartModalButton = modal.querySelector('.add-to-cart-modal-button');
    let productosCargados = []; 

    // --- Funciones de Interacción del Modal ---

    function openModal(productId) {
        // Usa == para comparar el ID del producto (número) con el data-attribute (string)
        const producto = productosCargados.find(p => p.idProductos == productId); 

        if (producto) {
            modalImage.src = (producto.imagen === null || producto.imagen === '') ? "../assets/css/tacosalpastor.png" : producto.imagen;
            modalImage.alt = producto.nombre;
            modalName.textContent = producto.nombre;
            modalPrice.textContent = `$${parseFloat(producto.precio).toFixed(2)} c/u`; // Formato de precio
            
            addToCartModalButton.setAttribute('data-product-id', producto.idProductos);

            modal.style.display = 'block';
            const quantityDisplay = modal.querySelector('.quantity-display');
            quantityDisplay.textContent = '1';
        } else {
            console.error(`Producto con ID ${productId} no encontrado.`);
        }
    }

    function closeModal() {
        modal.style.display = 'none';
    }


    
    async function cargarProductos() {
        try {
            const respuesta = await fetch(apiUrl); 
            
            if (!respuesta.ok) {
                throw new Error(`Error HTTP! Estado: ${respuesta.status}`);
            }

            const data = await respuesta.json(); // La respuesta completa: { error: ..., contenido: [...] }
            
            // se accede al array que contiene los productos despues del texto "contenido: [{...}]"
            const todosLosProductos = data.contenido; 
            
            // No sabia que se podia filtrar desde aqui; filtra solo las tortas (categoria 2);
            const tacosParaMostrar = todosLosProductos.filter(producto => producto.categoria == 2);

            // Guardar TODOS los productos cargados (incluyendo bebidas y tortas) para el modal
            // solo sirve si se quiere mostrar todo.
             productosCargados = todosLosProductos; 

            // se hace el for-each para mostrar los productos en el HTML
            tacosParaMostrar.forEach(producto => {
                
                // este es el div que contiene la informacion general del producto
                // <div class="dish-card menu-card">...</div>
                const dishCard = document.createElement('div');
                dishCard.classList.add('dish-card', 'menu-card');

                // contenedor de la imagen dentro de la tarjeta
                const cardImageContainer = document.createElement('div');
                cardImageContainer.classList.add('card-image-container');

                // obten la imagen del producto desde el array del contenido
                const imagen = document.createElement('img');
                // Si 'imagen' es null o vacío, usa la imagen por defecto.
                imagen.src = (producto.imagen === null || producto.imagen === '') ? "../assets/css/tacosalpastor.png" : producto.imagen; 
                imagen.alt = producto.nombre; 
    
                // hace el nombre del platillo con titulo de etiqueta (h3)
                const dishName = document.createElement('h3');
                dishName.textContent = producto.nombre;

                // coloca el precio del platillo con la eqtiqueta (p)
                const dishPrice = document.createElement('p');
                dishPrice.classList.add('price');
                // Usa parseFloat para asegurar que el precio se ponga correctamente
                dishPrice.textContent = `$${parseFloat(producto.precio).toFixed(2)} c/u`; 

                // Hace el botón de agregar al carrito
                const addToCartButton = document.createElement('button');
                addToCartButton.classList.add('add-to-cart-button', 'open-modal');
                addToCartButton.setAttribute('data-product-id', producto.idProductos);
                
                // *** EVENT LISTENER para ABRIR MODAL ***
                addToCartButton.addEventListener('click', () => {
                    const productId = addToCartButton.getAttribute('data-product-id');
                    openModal(productId);
                });
                // **************************************

                // pond la imagen del carrito dentro del botón
                const cartImage = document.createElement('img');
                cartImage.src = "../assets/css/carrito.png";
                cartImage.alt = "Agregar";

                // junta la imagen del carrito al botón
                addToCartButton.appendChild(cartImage);
    
                // Ensambla el contenedor de la imagen grande
                cardImageContainer.appendChild(imagen);
    
                // forma la tarjeta completa del producto
                dishCard.appendChild(cardImageContainer);
                dishCard.appendChild(dishName);
                dishCard.appendChild(dishPrice);
                dishCard.appendChild(addToCartButton);
    
                // añade la tarjeta al contenedor principal en el HTML
                contenedor.appendChild(dishCard);
            });

        } catch (error) {
            console.error('Error al cargar los productos:', error); 
            contenedor.innerHTML = `<p class="error-message">Error al cargar los productos: ${error.message}.</p>`; 
        }
    }

    // --- Ejecución y Cierre del Modal ---
    cargarProductos();
    
    closeButton.addEventListener('click', closeModal);
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    </script>
</body>
</html>
