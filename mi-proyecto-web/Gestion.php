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
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td>
                                        <div class="employee-name">
                                            <div class="avatar" style="background-color: #e2d9f3;">MR</div>
                                            <div>María Rodríguez</div>
                                        </div>
                                    </td>
                                    <td>maria.rodriguez@empresa.com</td>
                                    <td>RRHH</td>
                                    <td>Gerente</td>
                                    <td>15/03/2022</td>
                                    <td><span class="status-badge active">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-icon" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>002</td>
                                    <td>
                                        <div class="employee-name">
                                            <div class="avatar" style="background-color: #d0f0fd;">JL</div>
                                            <div>Juan López</div>
                                        </div>
                                    </td>
                                    <td>juan.lopez@empresa.com</td>
                                    <td>IT</td>
                                    <td>Desarrollador</td>
                                    <td>05/06/2023</td>
                                    <td><span class="status-badge active">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-icon" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>003</td>
                                    <td>
                                        <div class="employee-name">
                                            <div class="avatar" style="background-color: #f8d7e9;">CP</div>
                                            <div>Carlos Pérez</div>
                                        </div>
                                    </td>
                                    <td>carlos.perez@empresa.com</td>
                                    <td>Ventas</td>
                                    <td>Ejecutivo</td>
                                    <td>12/01/2021</td>
                                    <td><span class="status-badge active">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-icon" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>004</td>
                                    <td>
                                        <div class="employee-name">
                                            <div class="avatar" style="background-color: #ffda6a;">LG</div>
                                            <div>Laura Gómez</div>
                                        </div>
                                    </td>
                                    <td>laura.gomez@empresa.com</td>
                                    <td>Marketing</td>
                                    <td>Diseñadora</td>
                                    <td>20/09/2022</td>
                                    <td><span class="status-badge active">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-icon" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>005</td>
                                    <td>
                                        <div class="employee-name">
                                            <div class="avatar" style="background-color: #d0f0fd;">AM</div>
                                            <div>Ana Martínez</div>
                                        </div>
                                    </td>
                                    <td>ana.martinez@empresa.com</td>
                                    <td>Finanzas</td>
                                    <td>Contadora</td>
                                    <td>08/04/2023</td>
                                    <td><span class="status-badge active">Activo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-icon" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>006</td>
                                    <td>
                                        <div class="employee-name">
                                            <div class="avatar" style="background-color: #e2d9f3;">RD</div>
                                            <div>Roberto Díaz</div>
                                        </div>
                                    </td>
                                    <td>roberto.diaz@empresa.com</td>
                                    <td>IT</td>
                                    <td>Analista</td>
                                    <td>15/07/2021</td>
                                    <td><span class="status-badge inactive">Inactivo</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-icon" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pagination-container">
                        <div class="pagination-info">Mostrando 1 a 6 de 120 registros</div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Employee Detail Modal -->
    <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeDetailModalLabel">Detalles del Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="employee-detail-header">
                        <div class="employee-avatar">MR</div>
                        <div class="employee-info">
                            <h3>María Rodríguez</h3>
                            <p>Gerente de RRHH</p>
                            <span class="status-badge active">Activo</span>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Información Personal</h5>
                            <ul class="detail-list">
                                <li><span>ID:</span> 001</li>
                                <li><span>Correo:</span> maria.rodriguez@empresa.com</li>
                                <li><span>Teléfono:</span> +1 234 567 890</li>
                                <li><span>Fecha Nacimiento:</span> 15/05/1985</li>
                                <li><span>Dirección:</span> Calle Principal 123, Ciudad</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Información Laboral</h5>
                            <ul class="detail-list">
                                <li><span>Departamento:</span> RRHH</li>
                                <li><span>Cargo:</span> Gerente</li>
                                <li><span>Fecha Contratación:</span> 15/03/2022</li>
                                <li><span>Supervisor:</span> Carlos Gómez</li>
                                <li><span>Salario:</span> $5,000.00</li>
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
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar a este empleado? Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="scripts/Gestion-script.js"></script>
</body>
</html>