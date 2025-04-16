<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empleado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Enlace a tu CSS personalizado -->
    <link rel="stylesheet" href="styles/Form-styles.css">
    <style>
        /* Quitar flechas de los campos numéricos */
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield; /* Para Firefox */
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo-circle"></div>
                <h1 class="sidebar-title">StaffLink</h1>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-category">General</div>
                <a href="#" class="nav-item">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="bi bi-people"></i>
                    <span>Gestionar Empleados</span>
                </a>
                <a href="#" class="nav-item active">
                    <i class="bi bi-person-plus"></i>
                    <span>Añadir Empleado</span>
                </a>
                
            </nav>
            
            <div class="sidebar-footer">
                <a href="#" class="nav-item">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Cerrar sesión</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- Header -->
                <div class="dashboard-header">
                    <div>
                        <p class="welcome-text">Formulario</p>
                        <h1 class="dashboard-title">Registro de Empleado</h1>
                    </div>
                    
                    <div class="header-actions">
                        <div class="search-container">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="search-input" placeholder="Buscar...">
                        </div>
                    </div>
                </div>
                
                <!-- Form Card -->
                <div class="form-card">
                    <form>
                        <!-- Datos Personales -->
                        <div class="form-section">
                            <div class="section-header">
                                <h3>Datos Personales</h3>
                            </div>
                            <div class="section-body">
                                <div class="row g-3">
                                    <!-- Fila 1 -->
                                    <div class="col-md-2">
                                        <label>Prefijo</label>
                                        <input type="text" class="form-control" maxlength="2" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Tomo</label>
                                        <input type="number" class="form-control" name="tomo" maxlength="4" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Asiento</label>
                                        <input type="number" class="form-control" name="asiento" maxlength="5" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Primer Nombre</label>
                                        <input type="text" class="form-control" maxlength="25" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Segundo Nombre</label>
                                        <input type="text" class="form-control" maxlength="25">
                                    </div>

                                    <!-- Fila 2 -->
                                    <div class="col-md-4">
                                        <label>Primer Apellido</label>
                                        <input type="text" class="form-control" maxlength="25" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Segundo Apellido</label>
                                        <input type="text" class="form-control" maxlength="25">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Apellido Casada</label>
                                        <input type="text" class="form-control" maxlength="25">
                                    </div>

                                    <!-- Fila 3 -->
                                    <div class="col-md-4">
                                        <label>Género</label>
                                        <select class="form-select" required>
                                            <option value="">Seleccionar</option>
                                            <option value="0">Femenino</option>
                                            <option value="1">Masculino</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Estado Civil</label>
                                        <select class="form-select">
                                            <option value="0">Soltero</option>
                                            <option value="1">Casado</option>
                                            <option value="2">Divorciado</option>
                                            <option value="3">Viudo</option>
                                            <option value="4">Unión Libre</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Tipo de Sangre</label>
                                        <input type="text" class="form-control" maxlength="3">
                                    </div>

                                    <!-- Fila 4 -->
                                    <div class="col-md-4">
                                        <label>Usa apellido de casada</label>
                                        <select class="form-select">
                                            <option value="0">No</option>
                                            <option value="1">Sí</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Fecha Nacimiento</label>
                                        <input type="date" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contacto -->
                        <div class="form-section">
                            <div class="section-header pink">
                                <h3>Información de Contacto</h3>
                            </div>
                            <div class="section-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label>Teléfono</label>
                                        <input type="number" class="form-control" name="telefono" max="9999999" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Celular</label>
                                        <input type="number" class="form-control" name="celular" max="99999999" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Correo</label>
                                        <input type="email" class="form-control" maxlength="40">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="form-section">
                            <div class="section-header blue">
                                <h3>Dirección</h3>
                            </div>
                            <div class="section-body">
                                <div class="row g-3">
                                    <!-- Fila 5 -->
                                    <div class="col-md-4">
                                        <label>Provincia</label>
                                        <select id="provincia" class="form-select" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de provincias cargadas desde la base de datos -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Distrito</label>
                                        <select id="distrito" class="form-select" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de distritos cargadas dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Corregimiento</label>
                                        <select id="corregimiento" class="form-select" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de corregimientos cargadas dinámicamente -->
                                        </select>
                                    </div>

                                    <!-- Fila 6 -->
                                    <div class="col-md-4">
                                        <label>Calle</label>
                                        <input type="text" class="form-control" maxlength="30">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Casa</label>
                                        <input type="text" class="form-control" maxlength="10">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Comunidad</label>
                                        <input type="text" class="form-control" maxlength="25">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Laboral -->
                        <div class="form-section">
                            <div class="section-header purple">
                                <h3>Información Laboral</h3>
                            </div>
                            <div class="section-body">
                                <div class="row g-3">
                                    <!-- Fila 7 -->
                                    <div class="col-md-4">
                                        <label>Nacionalidad</label>
                                        <select id="nacionalidad" class="form-select" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de nacionalidades cargadas dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Fecha Contratación</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Cargo</label>
                                        <input type="text" class="form-control" maxlength="2">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Departamento</label>
                                        <input type="text" class="form-control" maxlength="2">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Estado</label>
                                        <select class="form-select">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-outline-secondary">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Registrar Empleado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para cargar provincias
            function cargarProvincias() {
                $.ajax({
                    url: 'scripts/main.php',
                    method: 'POST',
                    data: { action: 'getProvincias' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.provincias) {
                            $('#provincia').empty().append('<option value="">Seleccionar</option>');
                            $.each(response.provincias, function(index, provincia) {
                                $('#provincia').append('<option data-codigo="' + provincia.codigo + '" value="' + provincia.codigo + '">' + provincia.nombre + '</option>');
                            });
                        } else {
                            alert('No se encontraron provincias.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Error al cargar las provincias.');
                    }
                });
            }



            // Función para cargar distritos
            function cargarDistritos(provinciaId) {
                if (provinciaId) {
                    $.ajax({
                        url: 'scripts/main.php',
                        method: 'POST',
                        data: { provincias: provinciaId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.distritos) {
                                $('#distrito').empty().append('<option value="">Seleccionar</option>');
                                $.each(response.distritos, function(index, distrito) {
                                    $('#distrito').append('<option value="' + distrito.codigo + '">' + distrito.nombre + '</option>');
                                });
                                $('#corregimiento').empty().append('<option value="">Seleccionar</option>'); // Limpiar corregimientos
                            } else {
                                alert('No se encontraron distritos para esta provincia.');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Error al cargar los distritos.');
                        }
                    });
                } else {
                    $('#distrito').empty().append('<option value="">Seleccionar</option>');
                    $('#corregimiento').empty().append('<option value="">Seleccionar</option>');
                }
            }



            // Función para cargar corregimientos
            function cargarCorregimientos(distritoId) {
                if (distritoId) {
                    $.ajax({
                        url: 'scripts/main.php',
                        method: 'POST',
                        data: { distritos: distritoId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.corregimiento) {
                                $('#corregimiento').empty().append('<option value="">Seleccionar</option>');
                                $.each(response.corregimiento, function(index, corregimiento) {
                                    $('#corregimiento').append('<option value="' + corregimiento.codigo + '">' + corregimiento.nombre + '</option>');
                                });
                            } else {
                                alert('No se encontraron corregimientos para este distrito.');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Error al cargar los corregimientos.');
                        }
                    });
                } else {
                    $('#corregimiento').empty().append('<option value="">Seleccionar</option>');
                }
            }



            // Llamar a cargarProvincias y cargarNacionalidades al cargar la página
            cargarProvincias();
            

            // Manejar el cambio de provincia
            $('#provincia').change(function() {
                var provinciaCodigo = $(this).val(); // Obtener el código de la provincia seleccionada
                cargarDistritos(provinciaCodigo); // Cargar distritos de la provincia
                $('#corregimiento').empty().append('<option value="">Seleccionar</option>'); // Limpiar corregimientos
            });

            // Manejar el cambio de distrito
            $('#distrito').change(function() {
                var distritoCodigo = $(this).val(); // Obtener el código del distrito seleccionado
                cargarCorregimientos(distritoCodigo); // Cargar corregimientos del distrito
            });
        });

        
            // Función para cargar nacionalidades
            function cargarNacionalidades() {
                $.ajax({
                    url: 'scripts/main.php',
                    method: 'POST',
                    data: { action: 'getNacionalidades' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.nacionalidades) {
                            $('#nacionalidad').empty().append('<option value="">Seleccionar</option>');
                            $.each(response.nacionalidades, function(index, pais) {
                                $('#nacionalidad').append('<option value="' + pais.nombre + '">' + pais.nombre + '</option>'); // Asegurar que solo se use pais.nombre
                            });
                        } else {
                            alert('No se encontraron países.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Error al cargar los países.');
                    }
                });
            }
            cargarNacionalidades();
            //aqui inician las validaciones
            
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tomoInput = document.querySelector('input[name="tomo"]');
            const asientoInput = document.querySelector('input[name="asiento"]');

            tomoInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
            });

            asientoInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);
            });
        });
    </script>
</body>
</html>
