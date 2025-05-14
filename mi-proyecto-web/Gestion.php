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
                        
                        <a href="creacionU.php" class="btn btn-primary add-employee-btn">
                            <i class="bi bi-person-plus"></i> Añadir Empleado
                        </a>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="filters-card">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <label>Departamento</label>
                            <select class="form-select" id="departmentFilter">
                                <option value="">Todos</option>
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

                                // Consultar departamentos únicos
                                $sql_departamentos = "SELECT DISTINCT d.nombre FROM departamento d 
                                                     INNER JOIN empleados e ON d.codigo = e.departamento";
                                $result_departamentos = $conn->query($sql_departamentos);

                                if ($result_departamentos->num_rows > 0) {
                                    while ($row = $result_departamentos->fetch_assoc()) {
                                        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Estado</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">Todos</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
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
                        <h3>Historial Empleados Registrados</h3>
                        <div class="table-actions">
                            <button class="btn btn-sm btn-outline-secondary" id="exportBtn">
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
                            // Consultar empleados con información de departamento y cargo
                            $sql = "SELECT e.cedula, CONCAT(e.nombre1, ' ', e.apellido1) AS nombre, e.correo, 
                                   d.nombre AS departamento_nombre, c.nombre AS cargo_nombre, 
                                   e.f_contra, e.estado 
                                   FROM empleados e 
                                   LEFT JOIN departamento d ON e.departamento = d.codigo 
                                   LEFT JOIN cargo c ON e.cargo = c.codigo";
                            
                            // Generar ID automáticamente en el código
                            $id = 1;
                            $result = $conn->query($sql);
                            ?>
                            <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $id++ . "</td>";
                                    echo "<td>" . $row['nombre'] . "</td>";
                                    echo "<td>" . $row['correo'] . "</td>";
                                    echo "<td>" . $row['departamento_nombre'] . "</td>";
                                    echo "<td>" . $row['cargo_nombre'] . "</td>";
                                    echo "<td>" . $row['f_contra'] . "</td>";
                                    echo "<td>" . $row['cedula'] . "</td>";
                                    echo "<td><span class='status-badge " . ($row['estado'] == 1 ? 'active' : 'inactive') . "'>" . ($row['estado'] == 1 ? 'Activo' : 'Inactivo') . "</span></td>";
                                    echo "<td>";
                                    echo "<div class='action-buttons'>";
                                    echo "<button class='btn btn-sm btn-icon view-details' data-cedula='" . $row['cedula'] . "' title='Ver detalles'><i class='bi bi-eye'></i></button>";
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
                    <div class="table-header">
                        <h3>Historial de Empleados Eliminados</h3>
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
                            if ($result_inactivos && $result_inactivos->num_rows > 0) {
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
                            
                            // Cerrar la conexión
                            $conn->close();
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles del Empleado -->
    <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeDetailModalLabel">Detalles del Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="employeeDetails">
                    <div class="employee-detail-header">
                        <div class="employee-avatar" id="employeeInitials">--</div>
                        <div class="employee-info">
                            <h3 id="employeeName">Cargando...</h3>
                            <p id="employeePosition">Cargando...</p>
                            <span class="status-badge" id="employeeStatus">-</span>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Información Personal</h5>
                            <ul class="detail-list">
                                <li><span>Cédula:</span> <span id="employeeCedula">-</span></li>
                                <li><span>Correo:</span> <span id="employeeEmail">-</span></li>
                                <li><span>Teléfono:</span> <span id="employeePhone">-</span></li>
                                <li><span>Celular:</span> <span id="employeeMobile">-</span></li>
                                <li><span>Fecha Nacimiento:</span> <span id="employeeBirthdate">-</span></li>
                                <li><span>Género:</span> <span id="employeeGender">-</span></li>
                                <li><span>Estado Civil:</span> <span id="employeeMaritalStatus">-</span></li>
                                <li><span>Tipo de Sangre:</span> <span id="employeeBloodType">-</span></li>
                                <li><span>Nacionalidad:</span> <span id="employeeNationality">-</span></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Información Laboral</h5>
                            <ul class="detail-list">
                                <li><span>Departamento:</span> <span id="employeeDepartment">-</span></li>
                                <li><span>Cargo:</span> <span id="employeePosition2">-</span></li>
                                <li><span>Fecha Contratación:</span> <span id="employeeHireDate">-</span></li>
                            </ul>
                            
                            <h5 class="mt-4">Dirección</h5>
                            <ul class="detail-list">
                                <li><span>Provincia:</span> <span id="employeeProvince">-</span></li>
                                <li><span>Distrito:</span> <span id="employeeDistrict">-</span></li>
                                <li><span>Corregimiento:</span> <span id="employeeCorregimiento">-</span></li>
                                <li><span>Calle:</span> <span id="employeeStreet">-</span></li>
                                <li><span>Casa:</span> <span id="employeeHouse">-</span></li>
                                <li><span>Comunidad:</span> <span id="employeeCommunity">-</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Editar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este empleado?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="scripts/Gestion-script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let selectedCedula = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                selectedCedula = row.querySelector('td:nth-child(7)').textContent.trim(); // Cédula en la columna 7
            });
        });

        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function() {
                if (!selectedCedula) {
                    alert('Error: No se recibió la cédula del empleado.');
                    return;
                }

                // Enviar la solicitud al archivo eliminarE.php con la cédula
                fetch('scripts/eliminarE.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `cedula=${encodeURIComponent(selectedCedula)}`
                })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Mostrar la respuesta de la eliminación
                    location.reload(); // Recargar la página después de eliminar
                })
                .catch(error => console.error('Error:', error));

                // Cerrar el modal después de confirmar
                const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                if (deleteModal) {
                    deleteModal.hide();
                }
            });
        }    
    });
    </script>
</body>
</html>
