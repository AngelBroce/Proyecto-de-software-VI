<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="styles/Gestion-styles.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'styles/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- Header -->
                <div class="dashboard-header">
                    <div>
                        <p class="welcome-text">Recursos Humanos</p>
                        <h1 class="dashboard-title">Gestión de Empleados</h1>
                    </div>
                    
                    <div class="header-actions">
                        <div class="search-container">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="search-input" id="searchInput" placeholder="Buscar empleado...">
                        </div>
                        
                        <button class="btn btn-primary add-employee-btn">
                            <i class="bi bi-person-plus"></i> Añadir Empleado
                        </button>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="filters-card">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <label>Departamento</label>
                            <select class="form-select" id="departmentFilter">
                                <option value="">Todos</option>
                                <option value="IT">IT</option>
                                <option value="RRHH">RRHH</option>
                                <option value="Ventas">Ventas</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Finanzas">Finanzas</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Estado</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">Todos</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Ordenar por</label>
                            <select class="form-select" id="sortBy">
                                <option value="name">Nombre</option>
                                <option value="id">ID</option>
                                <option value="department">Departamento</option>
                                <option value="date">Fecha contratación</option>
                            </select>
                        </div>
                        <div class="col-md-2 mt-md-4">
                            <button class="btn btn-outline-primary w-100" id="applyFilters">
                                <i class="bi bi-funnel"></i> Aplicar Filtros
                            </button>
                        </div>
                        <div class="col-md-2 mt-md-4">
                            <button class="btn btn-outline-secondary w-100" id="resetFilters">
                                <i class="bi bi-arrow-counterclockwise"></i> Restablecer
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Employees Table -->
                <div class="table-card">
                    <div class="table-header">
                        <h3>Empleados Registrados</h3>
                        <div class="table-actions">
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-download"></i> Exportar
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#">Mostrar 10 registros</a></li>
                                    <li><a class="dropdown-item" href="#">Mostrar 25 registros</a></li>
                                    <li><a class="dropdown-item" href="#">Mostrar 50 registros</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Configurar columnas</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Departamento</th>
                                    <th>Cargo</th>
                                    <th>Fecha Contratación</th>
                                    <th>Cédula</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <?php
                            // Conexión a la base de datos
                            $host = "localhost";
                            $usuario = "admin";
                            $contrasena = "1234";
                            $basededatos = "ds6";
                            $conn = new mysqli($host, $usuario, $contrasena, $basededatos);

                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }

                            // Inicializamos el arreglo para los IDs
                            $ids = [];
                            $id = 1;

                            // Consultar empleados
                            $sql = "SELECT CONCAT(nombre1, ' ', apellido1) AS nombre, correo, departamento, cargo, f_contra, cedula, estado FROM empleados";
                            $result = $conn->query($sql);
                            ?>
                            <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $ids[] = $id;
                                    echo "<tr>";
                                    echo "<td>" . $id++ . "</td>";
                                    echo "<td>" . $row['nombre'] . "</td>";
                                    echo "<td>" . $row['correo'] . "</td>";
                                    echo "<td>" . $row['departamento'] . "</td>";
                                    echo "<td>" . $row['cargo'] . "</td>";
                                    echo "<td>" . $row['f_contra'] . "</td>";
                                    echo "<td>" . $row['cedula'] . "</td>";
                                    echo "<td><span class='status-badge " . ($row['estado'] == 1 ? 'active' : 'inactive') . "'>" . ($row['estado'] == 1 ? 'Activo' : 'Inactivo') . "</span></td>";
                                    echo "<td>";
                                    echo "<div class='action-buttons'>";
                                    echo "<button class='btn btn-sm btn-icon' title='Ver detalles'><i class='bi bi-eye'></i></button>";
                                    echo "<button class='btn btn-sm btn-icon' title='Editar'><i class='bi bi-pencil'></i></button>";
                                    echo "<button class='btn btn-sm btn-icon delete' title='Eliminar'><i class='bi bi-trash'></i></button>";
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No hay empleados registrados.</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Deleted Employees Table -->
                <div class="table-card">
                    <h3>Empleados Eliminados</h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Departamento</th>
                                    <th>Cargo</th>
                                    <th>Fecha Contratación</th>
                                    <th>Cédula</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <?php
                            // Consultar empleados eliminados
                            $sql_inactivos = "SELECT CONCAT(nombre1, ' ', apellido1) AS nombre, correo, departamento, cargo, f_contra, cedula, estado FROM e_eliminados";
                            $id_inactivos = 1;
                            $result_inactivos = $conn->query($sql_inactivos);
                            ?>
                            <tbody>
                            <?php
                            if ($result_inactivos->num_rows > 0) {
                                while ($row = $result_inactivos->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $id_inactivos++ . "</td>";
                                    echo "<td>" . $row['nombre'] . "</td>";
                                    echo "<td>" . $row['correo'] . "</td>";
                                    echo "<td>" . $row['departamento'] . "</td>";
                                    echo "<td>" . $row['cargo'] . "</td>";
                                    echo "<td>" . $row['f_contra'] . "</td>";
                                    echo "<td>" . $row['cedula'] . "</td>";
                                    echo "<td><span class='status-badge inactive'>Eliminado</span></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No hay empleados eliminados.</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const cedula = row.querySelector('td:nth-child(7)').textContent.trim();  // Cédula en la columna 7

                    // Mostrar el modal de confirmación
                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                    deleteModal.show();

                    // Configurar el botón de confirmación dentro del modal
                    const confirmButton = document.querySelector('#deleteConfirmModal .btn-danger');
                    confirmButton.onclick = function() {
                        fetch('scripts/eliminarE.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `cedula=${cedula}`  // Ahora enviamos la cédula
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert(data);
                            location.reload();  // Recargar la página después de la eliminación
                        })
                        .catch(error => console.error('Error:', error));

                        // Cerrar el modal después de confirmar
                        deleteModal.hide();
                    };
                });
            });
        });
    </script>
</body>
</html>
