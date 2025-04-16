<?php
// Incluir el archivo de conexión
include 'scripts/main.php';

// Consulta para obtener los empleados 
$query = "SELECT id_us, nombre1, apellido1 FROM empleados";
$result = $conn->query($query);

// Verificar si hay resultados
$empleados = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión RRHH - Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles/styles.css">
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
        <a href="#" class="nav-item active">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>

        <a href="#" class="nav-item">
          <i class="bi bi-people"></i>
          <span>Gestionar Empleados</span>
        </a>
        <a href="#" class="nav-item">
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
            <p class="welcome-text">Bienvenido,</p>
            <h1 class="dashboard-title">Dashboard</h1>
          </div>
          
          <div class="header-actions">
            <div class="search-container">
              <i class="bi bi-search search-icon"></i>
              <input type="text" class="search-input" placeholder="Buscar...">
            </div>
            
            <button class="btn btn-primary add-employee-btn">
              Añadir Empleado
            </button>
          </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row stats-row">
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-header bg-primary">
                <h3 class="stat-title">Total de Empleados</h3>
              </div>
              <div class="stat-body">
                <div class="stat-content">
                  <span class="stat-number">120</span>
                  <span class="stat-description">Número total de empleados registrados.</span>
                </div>
                <div class="stat-chart">
                  <div class="chart-bar" style="height: 40%;"></div>
                  <div class="chart-bar" style="height: 55%;"></div>
                  <div class="chart-bar" style="height: 70%;"></div>
                  <div class="chart-bar" style="height: 65%;"></div>
                  <div class="chart-bar" style="height: 80%;"></div>
                  <div class="chart-bar" style="height: 90%;"></div>
                  <div class="chart-bar" style="height: 75%;"></div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-header bg-success">
                <h3 class="stat-title">Empleados Activos</h3>
              </div>
              <div class="stat-body">
                <div class="stat-content">
                  <span class="stat-number">100</span>
                  <span class="stat-description">Empleados actualmente activos.</span>
                </div>
                <div class="stat-chart">
                  <div class="chart-bar bg-success" style="height: 60%;"></div>
                  <div class="chart-bar bg-success" style="height: 75%;"></div>
                  <div class="chart-bar bg-success" style="height: 85%;"></div>
                  <div class="chart-bar bg-success" style="height: 80%;"></div>
                  <div class="chart-bar bg-success" style="height: 90%;"></div>
                  <div class="chart-bar bg-success" style="height: 95%;"></div>
                  <div class="chart-bar bg-success" style="height: 85%;"></div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-header bg-danger">
                <h3 class="stat-title">Empleados Inactivos</h3>
              </div>
              <div class="stat-body">
                <div class="stat-content">
                  <span class="stat-number">20</span>
                  <span class="stat-description">Empleados que ya no están activos.</span>
                </div>
                <div class="stat-chart">
                  <div class="chart-bar bg-danger" style="height: 20%;"></div>
                  <div class="chart-bar bg-danger" style="height: 15%;"></div>
                  <div class="chart-bar bg-danger" style="height: 10%;"></div>
                  <div class="chart-bar bg-danger" style="height: 25%;"></div>
                  <div class="chart-bar bg-danger" style="height: 15%;"></div>
                  <div class="chart-bar bg-danger" style="height: 10%;"></div>
                  <div class="chart-bar bg-danger" style="height: 20%;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Employee List and Calendar -->
        <div class="row">
          <div class="col-md-8">
            <div class="stat-card">
              <div class="stat-header bg-secondary">
                <h3 class="stat-title">Empleados Registrados</h3>
              </div>
              <div class="stat-body p-0">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nombre Completo</th>
                      <th scope="col">Puesto</th>
                      <th scope="col">Departamento</th>
                      <th scope="col">Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($empleados)): ?>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?= htmlspecialchars($empleado['id']) ?></td>
                            <td><?= htmlspecialchars($empleado['nombre_completo']) ?></td>
                            <td><?= htmlspecialchars($empleado['puesto']) ?></td>
                            <td><?= htmlspecialchars($empleado['departamento']) ?></td>
                            <td><?= $empleado['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No hay empleados registrados.</td>
                    </tr>
                <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          
        </div>
        
        <!-- Recent Activity -->
        <div class="row mt-4">
          <div class="col-12">
            <div class="stat-card">
              <div class="stat-header bg-warning">
                <h3 class="stat-title">Actividad Reciente</h3>
              </div>
              <div class="stat-body">
                <div class="activity-list">
                  <div class="activity-item">
                    <div class="activity-icon">
                      <i class="bi bi-clock"></i>
                    </div>
                    <div class="activity-content">
                      <p class="activity-title">Actualización de sistema</p>
                      <p class="activity-time">Hace 2 horas</p>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon">
                      <i class="bi bi-clock"></i>
                    </div>
                    <div class="activity-content">
                      <p class="activity-title">Mantenimiento programado</p>
                      <p class="activity-time">Hace 5 horas</p>
                    </div>
                  </div>
                  
                  <div class="activity-item">
                    <div class="activity-icon">
                      <i class="bi bi-clock"></i>
                    </div>
                    <div class="activity-content">
                      <p class="activity-title">Nuevo empleado registrado</p>
                      <p class="activity-time">Hace 1 día</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JavaScript -->
  <script src="script.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>