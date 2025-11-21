<!DOCTYPE html>
<?php
SESSION_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Taquería El Gallo Giro</title>
    <link rel="stylesheet" href="../assets/css/style.css" />  
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
                <li><a href="indexA.php" class="">Inicio</a></li>                
            </ul>
        </nav>      
        <div class="admin-header-title">Panel de Administración</div>
        <button id="user-button" class="user-active" onclick="window.location.href='admin.php'"><?php echo htmlspecialchars($_SESSION['nombre']);?></button>
    </header>

    <main class="admin-main">
        <div class="admin-grid">
            
            <aside class="admin-sidebar">
                <h2 class="admin-greeting">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
                <nav>
                    <ul>
                        <li><a href="#" class="sidebar-link active-sidebar-link" id="link-inicio">Inicio</a></li>
                        
                        <li class="menu-dropdown-parent">
                            <a href="#" class="sidebar-link dropdown-toggle" id="link-menu-toggle">Menú <span class="dropdown-arrow"></span></a>
                            <ul class="dropdown-content" id="menu-submenu">
                                <li><a href="#" class="sidebar-link sub-link" data-type="tacos" id="link-tacos">Tacos</a></li>
                                <li><a href="#" class="sidebar-link sub-link" data-type="tortas" id="link-tortas">Tortas</a></li>
                                <li><a href="#" class="sidebar-link sub-link" data-type="bebidas" id="link-bebidas">Bebidas</a></li>
                            </ul>
                        </li>
                        
                        <li><a href="#" class="sidebar-link" id="link-pedidos">Pedidos</a></li>
                        <li><a href="#" class="sidebar-link" id="link-reportes">Reportes</a></li>
                        <li><a href="#" class="sidebar-link" id="link-personal">Personal</a></li>
                        <li><a href="#" class="sidebar-link" id="link-informacion-personal">Información personal</a></li>
                    </ul>
                </nav>
            </aside>

            <section class="admin-content">
                
                <div id="productos-panel" class="admin-panel active-panel">
                    
                    <div class="panel-header">
                        <button class="add-product-button" id="btn-add-product">+ Agregar nuevo producto</button>
                        <div class="search-bar">
                            <input type="text" placeholder="Buscar">
                            <button><img src="../assets/css/lupa.png" alt="Buscar"></button> 
                        </div>
                    </div>
                    
                    <h3 class="panel-title" id="product-management-title">Gestión de productos</h3>

                    <div id="product-list-container">
                        <div  data-product-type="tacos" >
                           <?php include "../controlador/listar_tacos.php"; ?>
                            
                        </div>                       
                                         
                        <div data-product-type="tortas">
                            <?php include "../controlador/listar_tortas.php"; ?>
                        </div>
                        <div data-product-type="bebidas">
                            <?php include "../controlador/listar_bebidas.php"; ?>
                        </div>
                    </div>
                </div>

                <div id="add-edit-product-panel" class="admin-panel hidden">
                    <h3 class="panel-title" id="add-edit-product-title">Agregar nuevo producto</h3>
                    
                    <form class="product-form" id="product-form" action="../controlador/CProducto.php" method="POST" enctype="multipart/form-data">
                        <div class="form-grid">
                            <input type="text" class="profile-input wide-input" placeholder="Nombre del producto" name="nombre" required pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras y espacios.">
                            <input type="text" class="profile-input price-input" placeholder="Precio" name="precio" required pattern="\d+(\.\d{1,2})?" title="Ingrese un precio válido (número con hasta dos decimales).">
                            <div class="input-group select-group">
                                <select id="categoria" name="categoria" required>
                                  <option value="" disabled selected>Categoría</option>
                                  <option value="0">Tacos</option>
                                   <option value="1">Bebidas</option>
                                   <option value="2">Tortas</option>
                                </select>
                            </div>
                            
                            <div class="file-upload-wrapper wide-input">
                                <input type="file" id="product-image-upload" accept="image/*" class="file-input" name="imagen" required>
                                <label for="product-image-upload" class="file-label">
                                    <img src="../assets/css/imagen.png" alt="Subir imagen">
                                    <span id="file-name-display">Subir imagen</span>
                                </label>
                            </div>
                            <div class="spacer"></div>
                        </div>
                        
                        <h4 class="form-subtitle">Complementos adicionales</h4>
                        
                        <div class="complements-container" id="product-complements-container">
                            </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="save-changes-button">Guardar producto</button>
                            <button type="button" class="cancel-button" id="cancel-product-btn">Cancelar</button>
                        </div>
                    </form>
                </div>

                <div id="solo_edit-product-panel" class="admin-panel hidden">
                    <h3 class="panel-title" id="add-edit-product-title">Editar un producto</h3>
                    
                    <form class="product-form" id="formEditarProducto" method="POST" enctype="multipart/form-data">
                        <!-- input hidden para guardar id del producto  -->
                        <input type="hidden" name="idProductos" id="edit-idProductos">
                        <div class="form-grid">
                            <input type="text" class="profile-input wide-input" placeholder="Nombre del producto" name="nombre2" id="edit-nombre2" required pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras y espacios.">
                            <input type="text" class="profile-input price-input" placeholder="Precio" name="precio2" id="edit-precio2" required pattern="\d+(\.\d{1,2})?" title="Ingrese un precio válido (número con hasta dos decimales).">
                            <div class="input-group select-group">
                                <select id="edit-categoria2" name="categoria2" required>
                                  <option value="" disabled selected>Categoría</option>
                                  <option value="0">Tacos</option>
                                   <option value="1">Bebidas</option>
                                   <option value="2">Tortas</option>
                                </select>
                            </div>
                            
                            <div class="file-upload-wrapper wide-input">
                                <input type="file" id="edit-product-image-upload" accept="image/*" class="file-input" name="imagen2">
                                <label for="edit-product-image-upload" class="file-label">
                                    <img src="../assets/css/imagen.png" alt="Subir imagen">
                                    <span id="file-name-display-edit">Subir imagen</span>
                                </label>
                            </div>
                            <div class="spacer"></div>
                        </div>
                        
                        <h4 class="form-subtitle">Complementos adicionales</h4>
                        
                        <div class="complements-container" id="product-complements-container-edit">
                            </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="save-changes-button">Editar producto</button>
                            <button type="button" class="cancel-button" id="cancel-edit-btn">Cancelar</button>
                        </div>
                    </form>
                </div>
                
                <div id="pedidos-panel" class="admin-panel hidden">
                    <h3 class="panel-title">Gestión de pedidos</h3>
                    
                    <div class="pedidos-sections-container">
                        
                        <div class="pedidos-table-wrapper">
                            <?php include "../controlador/pedidosEspera.php"; ?>
                        </div>
                        
                        <div class="pedidos-table-wrapper">
                            <?php include "../controlador/pedidosProceso.php"; ?>
                        </div>

                        <div class="pedidos-table-wrapper">
                            <?php include "../controlador/pedidosTerminados.php"; ?>
                        </div>
                    </div>
                </div>
                
                <div id="reportes-panel" class="admin-panel hidden">
                    <h3 class="panel-title">Generar reportes</h3>
                    
                    <form class="reportes-form" id="reportes-form" action="../controlador/CReporte.php" method="POST" enctype="multipart/form-data">
                        <div class="date-selectors">
                            <div class="select-wrapper">
                                <input type="date" class="profile-input" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha de inicio" required>
                                <span class="dropdown-arrow-date"></span>
                            </div>
                            <div class="select-wrapper">
                                <input type="date" class="profile-input" id="fecha_fin" name="fecha_fin" placeholder="Fecha de fin" required>
                                <span class="dropdown-arrow-date"></span>
                            </div>
                        </div>
                        
                        <div class="report-icon-box">
                            <img src="../assets/css/report_icon.png" alt="Icono de reporte" class="report-icon">
                            <button type="submit" class="save-changes-button">Generar reporte</button>
                        </div>
                    </form>
                </div>
                
                <div id="personal-panel" class="admin-panel hidden">
                    <div class="panel-header">
                        <button class="add-product-button" id="btn-add-person">+ Agregar nuevo personal</button>
                        <div class="search-bar">
                            <input type="text" placeholder="Buscar">
                            <button><img src="../assets/css/search_icon.png" alt="Buscar"></button>
                        </div>
                    </div>
                    
                    <h3 class="panel-title">Gestión del personal</h3>

                    <div id="person-list-container">
                        <div class="person-item-card" data-person-id="1">
                            <img src="../assets/css/profile_placeholder.png" alt="Brian Maturano Alvarado" class="person-image">
                            <div class="person-info">
                                <span class="person-name">Brian Maturano Alvarado</span>
                                <span class="person-role">Cajero</span>
                            </div>
                            <div class="person-actions">
                                <button class="action-button edit-person-button"><img src="../assets/css/edit_icon.png" alt="Editar"></button>
                                <button class="action-button delete-person-button"><img src="../assets/css/trash_icon_orange.png" alt="Eliminar"></button>
                            </div>
                        </div>

                        <div class="person-item-card" data-person-id="2">
                            <img src="../assets/css/profile_placeholder.png" alt="Isaias Echegaray Ortega" class="person-image">
                            <div class="person-info">
                                <span class="person-name">Isaias Echegaray Ortega</span>
                                <span class="person-role">Cocinero</span>
                            </div>
                            <div class="person-actions">
                                <button class="action-button edit-person-button"><img src="../assets/css/edit_icon.png" alt="Editar"></button>
                                <button class="action-button delete-person-button"><img src="../assets/css/trash_icon_orange.png" alt="Eliminar"></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="add-edit-personal-panel" class="admin-panel hidden">
                    <h3 class="panel-title" id="add-edit-personal-title">Agregar nuevo personal</h3>
                    
                    <form class="profile-form" id="person-form">
                        <input type="text" class="profile-input" placeholder="Nombre(s)">
                        <input type="text" class="profile-input" placeholder="Apellidos">

                        <div class="select-wrapper">
                            <input type="date" class="profile-input" placeholder="Fecha de nacimiento">
                        </div>
                        <input type="text" class="profile-input" placeholder="Dirección">

                        <select class="profile-input">
                            <option value="" disabled selected hidden>Género</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="otro">Otro</option>
                        </select>
                        
                        <input type="email" class="profile-input" placeholder="Correo Electrónico">

                        <div class="password-wrapper">
                            <input type="password" class="profile-input" placeholder="Contraseña">
                            <button type="button" class="toggle-password"><img src="../assets/css/eye_icon.png" alt="Ver"></button> 
                        </div>
                        <div class="password-wrapper">
                            <input type="password" class="profile-input" placeholder="Confirmar contraseña">
                            <button type="button" class="toggle-password"><img src="../assets/css/eye_icon.png" alt="Ver"></button>
                        </div>

                        <div class="full-width-control">
                            <button type="submit" class="save-changes-button">Guardar</button>
                            <button type="button" class="cancel-button">Cancelar</button>
                        </div>
                    </form>
                </div>

                <div id="informacion-personal-panel" class="admin-panel hidden">
                    <h3 class="panel-title">Información personal</h3>
                    
                    <form class="profile-form" action="../controlador/CUsuarioA.php" method="POST">
                        <input type="text" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" class="profile-input" placeholder="Nombre(s)" name="nombre" required pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras y espacios.">
                        <input type="text" value="<?php echo htmlspecialchars($_SESSION['apellidos']); ?>" class="profile-input" placeholder="Apellidos" name="apellidos" required pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras y espacios.">

                        <input type="date" value="<?php echo htmlspecialchars($_SESSION['fechaNac']); ?>" class="profile-input" name="fechaNac" required>
                        <input type="text" value="<?php echo htmlspecialchars($_SESSION['direccion']); ?>" class="profile-input" placeholder="Dirección" name="direccion" required>
                        <select class="profile-input" name="genero" required>
                            <option value="1" <?php if ($_SESSION['genero'] == 1) echo 'selected'; ?>>Masculino</option>
                            <option value="2" <?php if ($_SESSION['genero'] == 2) echo 'selected'; ?>>Femenino</option>

                        </select>
                        <input type="email" value="<?php echo htmlspecialchars($_SESSION['correo']); ?>" class="profile-input" placeholder="Correo Electrónico" name="correo" required>

                        <div class="password-wrapper">
                            <input type="password" value= "<?php $contra = $_SESSION['passwor']; echo htmlspecialchars($contra); ?>" class="profile-input" placeholder="Contraseña" name="passwor" required minlength="8">
                            <button type="button" class="toggle-password"><img src="../assets/css/eye_icon.png" alt="Ver"></button> 
                            
                        </div>
                        <div class="password-wrapper">
                            <input type="password" value="<?php $contra = $_SESSION['passwor']; echo htmlspecialchars($contra); ?>" class="profile-input" placeholder="Confirmar Contraseña" name="confirm_password" required minlength="8">
                            <button type="button" class="toggle-password"><img src="../assets/css/eye_icon.png" alt="Ver"></button>
                        </div>

                        <div class="full-width-control">
                            <button type="submit" class="save-changes-button">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.admin-sidebar .sidebar-link');
            const dropdownToggle = document.getElementById('link-menu-toggle');
            const menuSubmenu = document.getElementById('menu-submenu');
            const adminPanels = document.querySelectorAll('.admin-panel');
            const productCards = document.querySelectorAll('.product-item-card');
            const productManagementPanel = document.getElementById('productos-panel');
            const addEditProductPanel = document.getElementById('add-edit-product-panel');
            const personListPanel = document.getElementById('personal-panel');
            const addEditPersonPanel = document.getElementById('add-edit-personal-panel');
            
            const btnAddProduct = document.getElementById('btn-add-product');
            const btnAddPerson = document.getElementById('btn-add-person');
            const btnCancelProduct = document.getElementById('cancel-product-btn');
            const productTitle = document.getElementById('product-management-title');
            const complementsContainer = document.getElementById('product-complements-container');
            function showPanel(panelId) {
    adminPanels.forEach(panel => panel.classList.add('hidden'));
    document.getElementById(panelId).classList.remove('hidden');
}

            //Complementos por tipo de producto
            const complements = {
                tacos: ['Cilantro', 'Cebolla', 'Piña', 'Salsa verde', 'Salsa roja', 'Guacamole'],
                tortas: ['Jitomate', 'Cebolla', 'Aguacate', 'Chiles en rajas', 'Chipotle', 'Mayonesa'],
                bebidas: ['355 ml', '500 ml', '600 ml', 'Al tiempo', 'Fría'],
                none: []
            };

            //  Función para cambiar el contenido principal
            function showPanel(panelId) {
                adminPanels.forEach(panel => panel.classList.add('hidden'));
                document.getElementById(panelId).classList.remove('hidden');
            }

            //  para activar el enlace en la barra lateral
            function activateLink(clickedLink) {
                sidebarLinks.forEach(link => link.classList.remove('active-sidebar-link'));
                clickedLink.classList.add('active-sidebar-link');
            }

            //Función para filtrar productos/personal 
            function filterProducts(type) {
                productCards.forEach(card => {
                    if (type === 'all' || card.dataset.productType === type) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            }

            // Carga dinámica de complementos 
            function loadComplements(type, container) {
                container.innerHTML = '';
                const items = complements[type] || complements.none;
                items.forEach(complement => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'complement-button';
                    button.textContent = complement;
                    // Manejo del estado seleccionado (activo/inactivo)
                    button.addEventListener('click', function() {
                        this.classList.toggle('active');
                    });
                    container.appendChild(button);
                });
            }
            
            //Manejo del menú lateral
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const targetId = this.id.replace('link-', '');
                    
                    if (this === dropdownToggle) {
                        e.preventDefault(); 
                        menuSubmenu.classList.toggle('hidden');
                        this.querySelector('.dropdown-arrow').classList.toggle('up');
                        
                        // activa "Menú" y oculta los paneles de edición/agregar
                        if (!menuSubmenu.classList.contains('hidden')) {
                            activateLink(this);
                        } else {
                            this.classList.remove('active-sidebar-link');
                        }
                        return;
                    }

                    e.preventDefault(); 
                    activateLink(this);
                    
                    // Si se hace clic en otro enlace principal, oculta el submenú
                    if (!this.classList.contains('sub-link')) {
                         menuSubmenu.classList.add('hidden');
                         dropdownToggle.classList.remove('active-sidebar-link');
                         dropdownToggle.querySelector('.dropdown-arrow').classList.remove('up');
                    } else {
                        
                        dropdownToggle.classList.add('active-sidebar-link');
                        dropdownToggle.querySelector('.dropdown-arrow').classList.add('up');
                    }

                    // Lógica para mostrar los paneles de contenido
                    if (['tacos', 'tortas', 'bebidas'].includes(targetId)) {
                        showPanel('productos-panel');
                        productTitle.textContent = 'Gestión de ' + targetId.charAt(0).toUpperCase() + targetId.slice(1);
                        filterProducts(targetId);
                    } else if (targetId === 'inicio') {
                        showPanel('productos-panel');
                        productTitle.textContent = 'Gestión de productos';
                        filterProducts('all');
                    }
                    else {
                        showPanel(targetId + '-panel');
                    }
                });
            });

            //Funcionalidad de AGREGAR/EDITAR PRODUCTO
            function openProductForm(isEditing, productType = 'tacos') {
                showPanel('add-edit-product-panel');
                // Determina qué complementos cargar según el tipo
                let typeToLoad = productType; 
                
                if (!isEditing) {
                    const activeSubLink = document.querySelector('.sub-link.active-sidebar-link');
                    typeToLoad = activeSubLink ? activeSubLink.dataset.type : 'tacos';
                }
                
                loadComplements(typeToLoad, complementsContainer);
                
                const title = document.getElementById('add-edit-product-title');
                title.textContent = isEditing ? 'Editar producto' : 'Agregar nuevo producto';
                
                const saveButton = document.querySelector('#product-form .save-changes-button');
                saveButton.textContent = isEditing ? 'Guardar cambios' : 'Guardar producto';
            }
            
            // Botón Agregar
            btnAddProduct.addEventListener('click', () => openProductForm(false, 'tacos'));
            
            
            // Botón Editar
            productManagementPanel.addEventListener('click', function(e) {
                const editBtn = e.target.closest('.edit-button');
                if (!editBtn) return;

                const card = editBtn.closest('.product-item-card');
                if (!card) return;

                //Obtine id desde data-id
                const idFromData = card.dataset.id || card.dataset.idproductos || card.dataset.idProductos || card.dataset.idProductos;
                const id = idFromData ? idFromData : null;
                if (!id) {
                    alert('No se encontró el identificador del producto en la tarjeta (data-id).');
                    return;
                }

                
                fetch(`../controlador/buscarXIdProductos.php?idProductos=${encodeURIComponent(id)}`)
                    .then(resp => {
                        if (!resp.ok) throw new Error('Respuesta no OK del servidor');
                        return resp.json();
                    })
                    .then(data => {
                       
                        const product = data;
                        
                        const pid = product.idProductos || product.id || product.id_producto || product.idProducto;
                        if (!pid) {
                            console.warn('Objeto producto recibido:', product);
                            alert('No se pudieron obtener los datos del producto. Revisa la respuesta del despachador.');
                            return;
                        }

                        // Rellena campos del formulario de edición
                        document.getElementById('edit-idProductos').value = pid;
                        // nombre
                        const nombreField = document.getElementById('edit-nombre2');
                        if (nombreField) nombreField.value = product.nombre ?? product.name ?? '';

                        // precio
                        const precioField = document.getElementById('edit-precio2');
                        if (precioField) {
                        
                            precioField.value = product.precio ?? product.price ?? '';
                        }

                        // categoría
                        const categoriaField = document.getElementById('edit-categoria2');
                        if (categoriaField) categoriaField.value = (product.categoria ?? product.category ?? '');

                        
                        const fileNameSpan = document.getElementById('file-name-display-edit');
                        if (fileNameSpan) fileNameSpan.textContent = product.imagen ?? product.image ?? 'Subir imagen';

                        // Muestra panel de edición
                        showPanel('solo_edit-product-panel');
                    })
                    .catch(err => {
                        console.error('Error al obtener producto:', err);
                        alert('Ocurrió un error al obtener los datos del producto. Revisa la consola.');
                    });
            });
            //Fin del manejador de edicion

            // Botón Cancelar en el panel de edición
            document.querySelector('#solo_edit-product-panel .cancel-button')?.addEventListener('click', function() {
                showPanel('productos-panel');
            });

            // Botón Cancelar
            btnCancelProduct.addEventListener('click', function() {
                 showPanel('productos-panel');
                 
                 const activeSubLink = document.querySelector('.sub-link.active-sidebar-link');
                 const type = activeSubLink ? activeSubLink.dataset.type : 'all';
                 filterProducts(type);
            });
            
            // Manejo de la subida de imagen
            const fileInput = document.getElementById('product-image-upload');
            const fileNameDisplay = document.getElementById('file-name-display');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    fileNameDisplay.textContent = this.files.length > 0 ? this.files[0].name : 'Subir imagen';
                });
            }
            // Manejo de la subida de imagen para edición
            const editFileInput = document.getElementById('edit-product-image-upload');
            const editFileNameDisplay = document.getElementById('file-name-display-edit');
            if (editFileInput) {
                editFileInput.addEventListener('change', function() {
                    editFileNameDisplay.textContent = this.files.length > 0 ? this.files[0].name : 'Subir imagen';
                });
            }
            
            // --- Funcionalidad de AGREGAR/EDITAR PERSONAL (Pendiente)
            btnAddPerson.addEventListener('click', function() {
                showPanel('add-edit-personal-panel');
                document.getElementById('add-edit-personal-title').textContent = 'Agregar nuevo personal';
            });

            // Lógica para el botón Cancelar en el formulario de Personal
            document.querySelector('#add-edit-personal-panel .cancel-button').addEventListener('click', function() {
                showPanel('personal-panel');
            });
            
          
            // Inicializa mostrando el panel de "Productos"
            activateLink(document.getElementById('link-inicio'));
            showPanel('productos-panel');
        });
        
        document.addEventListener('DOMContentLoaded', () => {
    const formEditar = document.getElementById('formEditarProducto');
    if (!formEditar) return;

    formEditar.addEventListener('submit', async (e) => {
        e.preventDefault();

        const idProductos = document.getElementById('edit-idProductos').value;
        const precio = document.getElementById('edit-precio2').value;

        console.log("Enviando al servidor:", { idProductos, precio });

        const formData = new FormData();
        formData.append('idProductos', idProductos);
        formData.append('precio', precio);

        try {
            const response = await fetch('../controlador/editarProductos.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            if (data.success) {
                alert('Producto actualizado correctamente');
                window.location.href = 'admin.php';
                 // Recargar la lista de productos
                if (typeof cargarProductos === 'function') cargarProductos();
            } else {
                alert('No se pudo actualizar: ' + (data.error || 'Error desconocido'));
            }
        } catch (error) {
           
        }
    });
});
        //ELIMINAR PRODUCTO
        async function eliminarProducto(id) {
    if (!confirm("¿Seguro que deseas eliminar este producto?")) return;

    try {
        const formData = new FormData();
        formData.append("idProductos", id);

        const response = await fetch("../controlador/eliminarProducto.php", {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            alert("Producto eliminado correctamente");
            //Recarga la página o el panel
            location.reload();
        } else {
            alert("No se pudo eliminar: " + (data.error || "Error desconocido"));
        }
    } catch (error) {
        console.error("Error al eliminar:", error);
        alert("Ocurrió un error al intentar eliminar el producto.");
    }
}
//FIN ELIMINAR PRODUCTO

        //Funcionalidad de mostrar/ocultar contraseña
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
            });
        });
        
    //Captura los pedidos seleccionados al hacer clic en el botón
    document.addEventListener('DOMContentLoaded', () => {
    const botonCambiar = document.getElementById('btnCambiarEstado');
    
    if (botonCambiar) {
        botonCambiar.addEventListener('click', () => {
            const seleccionados = Array.from(document.querySelectorAll('.pedido-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (seleccionados.length === 0) {
                alert('Selecciona al menos un pedido para cambiar su estado.');
                return;
            }

            const idPedido = seleccionados[0];
            console.log("Pedido seleccionado:", idPedido);

            const formData = new FormData();
            formData.append('idPedido', idPedido);

            fetch('../controlador/editarPedidosEspera.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Recargar la página para actualizar la tabla
            })
            .catch(error => console.error('Error:', error));
        });
    }
});
// Captura los pedidos seleccionados al hacer clic en el botón
document.addEventListener('DOMContentLoaded', () => {
    const botonCambiar = document.getElementById('btnCambiarEstadoProceso');
    
    if (botonCambiar) {
        botonCambiar.addEventListener('click', () => {
            const seleccionados = Array.from(
                document.querySelectorAll('#pedidos-proceso .pedido-checkbox:checked')
            ).map(checkbox => checkbox.value);

            if (seleccionados.length === 0) {
                alert('Selecciona al menos un pedido para cambiar su estado.');
                return;
            }

            const idPedido = seleccionados[0];
            console.log("Pedido seleccionado (proceso):", idPedido);

            const formData = new FormData();
            formData.append('idPedido', idPedido);

            fetch('../controlador/editarPedidosProceso.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Recargar para actualizar tablas
            })
            .catch(error => console.error('Error:', error));
        });
    }
});

    </script>
</body>
</html>
