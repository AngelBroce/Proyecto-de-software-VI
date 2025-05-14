<?php
// visualizacion.php
// Incluir conexión a la base de datos si es necesario
include 'scripts/main.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Empleados</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="styles/LogIn-styles.css">
    <style>
        /* Estilos adicionales específicos para esta página */
        html, body {
            overflow-y: auto !important;
        }
        body {
            overflow-y: auto !important;
        }
        .login-container {
            display: flex;
            flex-direction: row;
            height: 100vh;
        }
        .main-content {
            
            height: auto !important;
        }
        .employee-search-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 24px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .employee-search-header {
            background-color: #6f42c1; /* Color morado para esta sección */
            padding: 20px;
            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }
        
        .employee-search-body {
            padding: 24px;
        }
        
        .search-button {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #000;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .search-button:hover {
            background-color: #333;
            transform: scale(1.05);
        }
        
        .employee-details-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }
        
        .employee-details-header {
            background-color: #0dcaf0; /* Color azul para esta sección */
            padding: 20px;
            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
        }
        
        .edit-button {
            position: absolute;
            right: 20px;
            top: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .edit-button:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }
        
        .employee-avatar {
            width: 64px;
            height: 64px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: #0dcaf0;
        }
        
        .employee-details-body {
            padding: 24px;
        }
        
        .detail-section {
            margin-bottom: 24px;
        }
        
        .detail-section h4 {
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            color: #444;
        }
        
        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .detail-list li {
            display: flex;
            margin-bottom: 12px;
        }
        
        .detail-list li .detail-label {
            width: 40%;
            font-weight: 500;
            color: #666;
        }
        
        .detail-list li .detail-value {
            width: 60%;
            font-weight: 400;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-badge.active {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .status-badge.inactive {
            background-color: #f8d7da;
            color: #842029;
        }
        
        .no-results {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .no-results i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #ddd;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Sidebar -->
        <?php include 'styles/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- Header -->
                <div class="dashboard-header mb-4">
                    <div>
                        <p class="welcome-text">Recursos Humanos</p>
                        <h1 class="dashboard-title">Visualización de Empleados</h1>
                    </div>
                </div>
                
                <!-- Search Card (Moved to top) -->
                <div class="employee-search-card">
                    <div class="employee-search-header">
                        <h3 class="m-0">Buscar Empleado</h3>
                    </div>
                    <div class="employee-search-body">
                        <form id="searchForm">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="mb-0">
                                        <input type="text" class="form-control" id="employeeId" name="cedula" placeholder="Ingrese la cédula del empleado (ej: 08-1019-49)" required>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="submit" class="search-button ms-auto">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Employee Details Card (initially hidden) -->
                <div id="employeeDetailsCard" class="employee-details-card mt-4" style="display: none;">
                    <div class="employee-details-header">
                        <div class="employee-avatar" id="employeeInitials">--</div>
                        <div>
                            <h3 id="employeeName" class="m-0">Nombre del Empleado</h3>
                            <p id="employeePosition" class="m-0 mt-1">Cargo</p>
                            <span id="employeeStatus" class="status-badge active mt-2">Activo</span>
                        </div>
                        <button id="editButton" class="edit-button" title="Editar información">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                    
                    <!-- Vista de detalles (visible por defecto) -->
                    <div id="detailsView" class="employee-details-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <h4><i class="bi bi-person-vcard me-2"></i>Información Personal</h4>
                                    <ul class="detail-list">
                                        <li>
                                            <span class="detail-label">Cédula:</span>
                                            <span class="detail-value" id="employeeCedula">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Correo:</span>
                                            <span class="detail-value" id="employeeEmail">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Teléfono:</span>
                                            <span class="detail-value" id="employeePhone">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Celular:</span>
                                            <span class="detail-value" id="employeeMobile">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Fecha Nacimiento:</span>
                                            <span class="detail-value" id="employeeBirthdate">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Género:</span>
                                            <span class="detail-value" id="employeeGender">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Estado Civil:</span>
                                            <span class="detail-value" id="employeeMaritalStatus">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Tipo de Sangre:</span>
                                            <span class="detail-value" id="employeeBloodType">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Nacionalidad:</span>
                                            <span class="detail-value" id="employeeNationality">-</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-section">
                                    <h4><i class="bi bi-briefcase me-2"></i>Información Laboral</h4>
                                    <ul class="detail-list">
                                        <li>
                                            <span class="detail-label">Departamento:</span>
                                            <span class="detail-value" id="employeeDepartment">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Cargo:</span>
                                            <span class="detail-value" id="employeePosition2">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Fecha Contratación:</span>
                                            <span class="detail-value" id="employeeHireDate">-</span>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="detail-section">
                                    <h4><i class="bi bi-geo-alt me-2"></i>Dirección</h4>
                                    <ul class="detail-list">
                                        <li>
                                            <span class="detail-label">Provincia:</span>
                                            <span class="detail-value" id="employeeProvince">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Distrito:</span>
                                            <span class="detail-value" id="employeeDistrict">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Corregimiento:</span>
                                            <span class="detail-value" id="employeeCorregimiento">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Calle:</span>
                                            <span class="detail-value" id="employeeStreet">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Casa:</span>
                                            <span class="detail-value" id="employeeHouse">-</span>
                                        </li>
                                        <li>
                                            <span class="detail-label">Comunidad:</span>
                                            <span class="detail-value" id="employeeCommunity">-</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Vista de edición (oculta por defecto) -->
                    <div id="editView" class="employee-details-body" style="display: none;">
                        <form id="editForm" class="edit-form">
                            <input type="hidden" id="editCedula" name="cedula">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-section">
                                        <h4><i class="bi bi-person-vcard me-2"></i>Información Personal</h4>
                                        
                                        <div class="mb-3">
                                            <label for="editNombre1">Primer Nombre</label>
                                            <input type="text" class="form-control" id="editNombre1" name="nombre1">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editNombre2">Segundo Nombre</label>
                                            <input type="text" class="form-control" id="editNombre2" name="nombre2">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editApellido1">Primer Apellido</label>
                                            <input type="text" class="form-control" id="editApellido1" name="apellido1">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editApellido2">Segundo Apellido</label>
                                            <input type="text" class="form-control" id="editApellido2" name="apellido2">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editCorreo">Correo</label>
                                            <input type="email" class="form-control" id="editCorreo" name="correo">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editTelefono">Teléfono</label>
                                            <input type="tel" class="form-control" id="editTelefono" name="telefono">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editCelular">Celular</label>
                                            <input type="tel" class="form-control" id="editCelular" name="celular">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="detail-section">
                                        <h4><i class="bi bi-briefcase me-2"></i>Información Laboral</h4>
                                        
                                        <div class="mb-3">
                                            <label for="editDepartamento">Departamento</label>
                                            <select class="form-select" id="editDepartamento" name="departamento">
                                                <?php
                                                // Obtener departamentos de la base de datos
                                                $sql_departamentos = "SELECT codigo, nombre FROM departamento ORDER BY nombre";
                                                $result_departamentos = $conn->query($sql_departamentos);
                                                
                                                if ($result_departamentos && $result_departamentos->num_rows > 0) {
                                                    while ($row = $result_departamentos->fetch_assoc()) {
                                                        echo "<option value='" . $row['codigo'] . "'>" . $row['nombre'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editCargo">Cargo</label>
                                            <select class="form-select" id="editCargo" name="cargo">
                                                <?php
                                                // Obtener cargos de la base de datos
                                                $sql_cargos = "SELECT codigo, nombre FROM cargo ORDER BY nombre";
                                                $result_cargos = $conn->query($sql_cargos);
                                                
                                                if ($result_cargos && $result_cargos->num_rows > 0) {
                                                    while ($row = $result_cargos->fetch_assoc()) {
                                                        echo "<option value='" . $row['codigo'] . "'>" . $row['nombre'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editEstado">Estado</label>
                                            <select class="form-select" id="editEstado" name="estado">
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-section">
                                        <h4><i class="bi bi-geo-alt me-2"></i>Dirección</h4>
                                        
                                        <div class="mb-3">
                                            <label for="editCalle">Calle</label>
                                            <input type="text" class="form-control" id="editCalle" name="calle">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editCasa">Casa</label>
                                            <input type="text" class="form-control" id="editCasa" name="casa">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="editComunidad">Comunidad</label>
                                            <input type="text" class="form-control" id="editComunidad" name="comunidad">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" id="cancelEditBtn" class="btn btn-outline-secondary">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- No Results Message (initially hidden) -->
                <div id="noResultsMessage" class="no-results" style="display: none;">
                    <i class="bi bi-search"></i>
                    <h4>No se encontró ningún empleado</h4>
                    <p>Intente con otra cédula o verifique que el empleado esté registrado.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('searchForm');
        const employeeDetailsCard = document.getElementById('employeeDetailsCard');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const editButton = document.getElementById('editButton');
        const detailsView = document.getElementById('detailsView');
        const editView = document.getElementById('editView');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editForm = document.getElementById('editForm');
        
        let currentEmployeeData = null;
        
        // Función para buscar empleado
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const cedula = document.getElementById('employeeId').value.trim();
            if (!cedula) {
                alert('Por favor, ingrese una cédula válida.');
                return;
            }
            
            // Ocultar resultados anteriores
            employeeDetailsCard.style.display = 'none';
            noResultsMessage.style.display = 'none';
            
            // Realizar la búsqueda del empleado
            fetch('scripts/obtener_empleado.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `cedula=${encodeURIComponent(cedula)}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la respuesta del servidor: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                
                // Guardar los datos del empleado para edición
                currentEmployeeData = data;
                
                // Mostrar los detalles del empleado
                document.getElementById('employeeName').textContent = `${data.nombre1} ${data.nombre2 || ''} ${data.apellido1} ${data.apellido2 || ''}`.trim();
                document.getElementById('employeePosition').textContent = data.cargo_nombre || 'No asignado';
                
                // Establecer las iniciales para el avatar
                const initials = `${data.nombre1.charAt(0).toUpperCase()}${data.apellido1.charAt(0).toUpperCase()}`;
                document.getElementById('employeeInitials').textContent = initials;
                
                // Establecer el estado
                const statusElement = document.getElementById('employeeStatus');
                statusElement.textContent = data.estado == 1 ? 'Activo' : 'Inactivo';
                statusElement.className = `status-badge ${data.estado == 1 ? 'active' : 'inactive'}`;
                
                // Información personal
                document.getElementById('employeeCedula').textContent = data.cedula;
                document.getElementById('employeeEmail').textContent = data.correo || 'No disponible';
                document.getElementById('employeePhone').textContent = data.telefono || 'No disponible';
                document.getElementById('employeeMobile').textContent = data.celular || 'No disponible';
                document.getElementById('employeeBirthdate').textContent = data.f_nacimiento || 'No disponible';
                document.getElementById('employeeGender').textContent = data.genero_texto;
                document.getElementById('employeeMaritalStatus').textContent = data.estado_civil_texto;
                document.getElementById('employeeBloodType').textContent = data.tipo_sangre || 'No disponible';
                document.getElementById('employeeNationality').textContent = data.nacionalidad_nombre || 'No disponible';
                
                // Información laboral
                document.getElementById('employeeDepartment').textContent = data.departamento_nombre || 'No asignado';
                document.getElementById('employeePosition2').textContent = data.cargo_nombre || 'No asignado';
                document.getElementById('employeeHireDate').textContent = data.f_contra || 'No disponible';
                
                // Dirección
                document.getElementById('employeeProvince').textContent = data.provincia_nombre || 'No disponible';
                document.getElementById('employeeDistrict').textContent = data.distrito_nombre || 'No disponible';
                document.getElementById('employeeCorregimiento').textContent = data.corregimiento_nombre || 'No disponible';
                document.getElementById('employeeStreet').textContent = data.calle || 'No disponible';
                document.getElementById('employeeHouse').textContent = data.casa || 'No disponible';
                document.getElementById('employeeCommunity').textContent = data.comunidad || 'No disponible';
                
                // Llenar el formulario de edición
                document.getElementById('editCedula').value = data.cedula;
                document.getElementById('editNombre1').value = data.nombre1 || '';
                document.getElementById('editNombre2').value = data.nombre2 || '';
                document.getElementById('editApellido1').value = data.apellido1 || '';
                document.getElementById('editApellido2').value = data.apellido2 || '';
                document.getElementById('editCorreo').value = data.correo || '';
                document.getElementById('editTelefono').value = data.telefono || '';
                document.getElementById('editCelular').value = data.celular || '';
                
                // Seleccionar departamento y cargo
                if (document.getElementById('editDepartamento').querySelector(`option[value="${data.departamento}"]`)) {
                    document.getElementById('editDepartamento').value = data.departamento;
                }
                
                if (document.getElementById('editCargo').querySelector(`option[value="${data.cargo}"]`)) {
                    document.getElementById('editCargo').value = data.cargo;
                }
                
                document.getElementById('editEstado').value = data.estado;
                document.getElementById('editCalle').value = data.calle || '';
                document.getElementById('editCasa').value = data.casa || '';
                document.getElementById('editComunidad').value = data.comunidad || '';
                
                // Mostrar la vista de detalles
                detailsView.style.display = 'block';
                editView.style.display = 'none';
                
                // Mostrar la tarjeta de detalles
                employeeDetailsCard.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                // Mostrar mensaje de no resultados
                noResultsMessage.style.display = 'block';
            });
        });
        
        // Cambiar a modo edición
        editButton.addEventListener('click', function() {
            detailsView.style.display = 'none';
            editView.style.display = 'block';
        });
        
        // Cancelar edición
        cancelEditBtn.addEventListener('click', function() {
            detailsView.style.display = 'block';
            editView.style.display = 'none';
        });
        
        // Guardar cambios
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(editForm);
            
            // Enviar datos al servidor
            fetch('scripts/actualizar_empleado.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la respuesta del servidor: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                
                alert('Información actualizada correctamente');
                
                // Volver a cargar los datos del empleado
                document.getElementById('employeeId').value = formData.get('cedula');
                searchForm.dispatchEvent(new Event('submit'));
                
                // Volver a la vista de detalles
                detailsView.style.display = 'block';
                editView.style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar la información: ' + error.message);
            });
        });
    });
    </script>
</body>
</html>