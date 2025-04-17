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
                    <form action="" method="POST">
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
                                        <input type="text" class="form-control" name="prefijo" maxlength="2" required>
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
                                        <input type="text" class="form-control" name="nombre1" maxlength="25" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Segundo Nombre</label>
                                        <input type="text" class="form-control" name="nombre2" maxlength="25">
                                    </div>

                                    <!-- Fila 2 -->
                                    <div class="col-md-4">
                                        <label>Primer Apellido</label>
                                        <input type="text" class="form-control" name="apellido1" maxlength="25" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Segundo Apellido</label>
                                        <input type="text" class="form-control" name="apellido2" maxlength="25">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Apellido Casada</label>
                                        <input type="text" class="form-control" name="apellido_casada" maxlength="25">
                                    </div>

                                    <!-- Fila 3 -->
                                    <div class="col-md-4">
                                        <label>Género</label>
                                        <select class="form-select" name="genero" required>
                                            <option value="">Seleccionar</option>
                                            <option value="0">Femenino</option>
                                            <option value="1">Masculino</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Estado Civil</label>
                                        <select class="form-select" name="estado_civil">
                                            <option value="0">Soltero</option>
                                            <option value="1">Casado</option>
                                            <option value="2">Divorciado</option>
                                            <option value="3">Viudo</option>
                                            <option value="4">Unión Libre</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Tipo de Sangre</label>
                                        <select class="form-select" name="tipo_sangre">
                                            <option value="">Seleccionar</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>

                                    <!-- Fila 4 -->
                                    <div class="col-md-4">
                                        <label>Usa apellido de casada</label>
                                        <select class="form-select" name="usa_ac">
                                            <option value="0">No</option>
                                            <option value="1">Sí</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Fecha Nacimiento</label>
                                        <input type="date" class="form-control" name="f_nacimiento" required>
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
                                        <input type="email" class="form-control" name="correo" maxlength="40" required>
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
                                        <select id="provincia" class="form-select" name="provincia" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de provincias cargadas desde la base de datos -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Distrito</label>
                                        <select id="distrito" class="form-select" name="distrito" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de distritos cargadas dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Corregimiento</label>
                                        <select id="corregimiento" class="form-select" name="corregimiento" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de corregimientos cargadas dinámicamente -->
                                        </select>
                                    </div>

                                    <!-- Fila 6 -->
                                    <div class="col-md-4">
                                        <label>Calle</label>
                                        <input type="text" class="form-control" name="calle" maxlength="30">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Casa</label>
                                        <input type="text" class="form-control" name="casa" maxlength="10">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Comunidad</label>
                                        <input type="text" class="form-control" name="comunidad" maxlength="25">
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
                                        <select id="nacionalidad" class="form-select" name="nacionalidad" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de nacionalidades cargadas dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Fecha Contratación</label>
                                        <input type="date" class="form-control" name="f_contratacion">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Cargo</label>
                                        <select id="cargo" class="form-select" name="cargo" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de cargos cargadas dinámicamente -->
                                        </select>
                                        <span id="cargo-nombre"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Departamento</label>
                                        <select id="departamento" class="form-select" name="departamento" required>
                                            <option value="">Seleccionar</option>
                                            <!-- Opciones de departamentos cargadas dinámicamente -->
                                        </select>
                                        <span id="departamento-nombre"></span>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Estado</label>
                                        <select class="form-select" name="estado">
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
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $nombre1 = strtolower(trim($_POST['nombre1'] ?? ''));
                        $apellido1 = strtolower(trim($_POST['apellido1'] ?? ''));

                        // Generar correo institucional automáticamente
                        $correo = $nombre1 . '.' . $apellido1 . '@tudominio.com';

                        // Generar contraseña aleatoria de 10 caracteres
                        function generar_contraseña($longitud = 10) {
                            $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*';
                            return substr(str_shuffle($caracteres), 0, $longitud);
                        }
                        $contrasena = generar_contraseña();

                        echo "<script>alert('Correo institucional: $correo\\nContraseña: $contrasena');</script>";
                    }
                    ?>
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
                                $('#provincia').append('<option value="' + provincia.codigo + '">' + provincia.nombre + '</option>');
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

            // Llamar a cargarProvincias al cargar la página
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

            function cargarNacionalidades() {
                $.ajax({
                    url: 'scripts/main.php',
                    method: 'POST',
                    data: { action: 'getNacionalidades' },
                    dataType: 'json',
                    success: function (response) {
                        if (response.nacionalidades) {
                            $('#nacionalidad').empty().append('<option value="">Seleccionar</option>');
                            $.each(response.nacionalidades, function (index, pais) {
                                $('#nacionalidad').append('<option value="' + pais.codigo + '">' + pais.nombre + '</option>');
                            });
                        } else {
                            alert('No se encontraron países.');
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Error al cargar las nacionalidades.');
                    }
                });
            }

            cargarNacionalidades();

            // Puedes implementar cargarDepartamentos() y cargarCargos() si son dinámicos
        });
    </script>
    <script>
        $(document).ready(function() {
            // Función para cargar departamentos
            function cargarDepartamentos() {
                $.ajax({
                    url: 'scripts/main.php',
                    method: 'POST',
                    data: { action: 'getDepartamentos' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.departamentos) {
                            $('#departamento').empty().append('<option value="">Seleccionar</option>');
                            $.each(response.departamentos, function(index, departamento) {
                                $('#departamento').append('<option value="' + departamento.codigo + '">' + departamento.nombre + '</option>');
                            });
                        } else {
                            alert('No se encontraron departamentos.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Error al cargar los departamentos.');
                    }
                });
            }

            // Función para cargar cargos según el departamento seleccionado
            function cargarCargosPorDepartamento(departamentoCodigo) {
                if (departamentoCodigo) {
                    $.ajax({
                        url: 'scripts/main.php',
                        method: 'POST',
                        data: { action: 'getCargosPorDepartamento', departamento: departamentoCodigo },
                        dataType: 'json',
                        success: function(response) {
                            if (response.cargos) {
                                $('#cargo').empty().append('<option value="">Seleccionar</option>');
                                $.each(response.cargos, function(index, cargo) {
                                    $('#cargo').append('<option value="' + cargo.codigo + '">' + cargo.nombre + '</option>');
                                });
                            } else {
                                alert('No se encontraron cargos para este departamento.');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Error al cargar los cargos.');
                        }
                    });
                } else {
                    $('#cargo').empty().append('<option value="">Seleccionar</option>');
                }
            }

            // Llamar a cargarDepartamentos al cargar la página
            cargarDepartamentos();

            // Manejar el cambio de departamento
            $('#departamento').change(function() {
                var departamentoCodigo = $(this).val(); // Obtener el código del departamento seleccionado
                cargarCargosPorDepartamento(departamentoCodigo); // Cargar cargos del departamento
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tomoInput = document.querySelector('input[name="tomo"]');
            const asientoInput = document.querySelector('input[name="asiento"]');
            const cargoInput = document.querySelector('input[name="cargo"]');
            const departamentoInput = document.querySelector('input[name="departamento"]');

            tomoInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
            });

            asientoInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);
            });

            cargoInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);
                if (this.value < 1) this.value = '';
                if (this.value > 99) this.value = '99';
            });

            departamentoInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2);
                if (this.value < 1) this.value = '';
                if (this.value > 99) this.value = '99';
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                alert('Empleado registrado exitosamente.');
                document.querySelector('form').reset(); // Limpiar formulario
            }
        });
    </script>
</body>
</html>
