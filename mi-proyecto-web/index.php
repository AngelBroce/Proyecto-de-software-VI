<?php
// Incluir el archivo de conexión
include 'scripts/main.php';

// Consulta para obtener todos los empleados
$query = "SELECT e.cedula, e.nombre1, e.apellido1, d.nombre AS departamento, c.nombre AS puesto, e.estado 
          FROM empleados e 
          LEFT JOIN departamento d ON e.departamento = d.codigo 
          LEFT JOIN cargo c ON e.cargo = c.codigo";

$result = $conn->query($query);

// Verificar si hay resultados
$empleados = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
}

// Contar empleados totales, activos e inactivos
$totalEmpleados = count($empleados);
$empleadosActivos = 0;
$empleadosInactivos = 0;

foreach ($empleados as $empleado) {
    if ($empleado['estado'] == 1) {
        $empleadosActivos++;
    } else {
        $empleadosInactivos++;
    }
}

// Obtener actividad reciente (últimas acciones en la base de datos)
$queryActividad = "SELECT * FROM (
                    SELECT 'Empleado agregado' as tipo_accion, 
                           CONCAT(nombre1, ' ', apellido1) as nombre_empleado, 
                           f_contra as fecha_accion 
                    FROM empleados 
                    ORDER BY f_contra DESC 
                    LIMIT 5
                   ) as agregados
                   UNION ALL
                   SELECT * FROM (
                    SELECT 'Empleado eliminado' as tipo_accion, 
                           CONCAT(nombre1, ' ', apellido1) as nombre_empleado, 
                           f_contra as fecha_accion 
                    FROM e_eliminados 
                    ORDER BY f_contra DESC 
                    LIMIT 5
                   ) as eliminados
                   ORDER BY fecha_accion DESC
                   LIMIT 5";

$resultActividad = $conn->query($queryActividad);
$actividades = [];
if ($resultActividad && $resultActividad->num_rows > 0) {
    while ($row = $resultActividad->fetch_assoc()) {
        $actividades[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
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
    <?php include 'styles/sidebar.php'; ?>
    
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
            <a href="creacionU.php" class="btn btn-primary add-employee-btn">
              Añadir Empleado
            </a>
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
                  <span class="stat-number"><?php echo $totalEmpleados; ?></span>
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
                  <span class="stat-number"><?php echo $empleadosActivos; ?></span>
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
                  <span class="stat-number"><?php echo $empleadosInactivos; ?></span>
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
                    <?php foreach ($empleados as $index => $empleado): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($empleado['nombre1'] . ' ' . $empleado['apellido1']) ?></td>
                            <td><?= htmlspecialchars($empleado['puesto'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($empleado['departamento'] ?? 'N/A') ?></td>
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
                  <?php if (!empty($actividades)): ?>
                    <?php foreach ($actividades as $actividad): ?>
                      <div class="activity-item">
                        <div class="activity-icon">
                          <i class="bi <?php echo ($actividad['tipo_accion'] == 'Empleado agregado') ? 'bi-person-plus' : 'bi-person-dash'; ?>"></i>
                        </div>
                        <div class="activity-content">
                          <p class="activity-title"><?php echo $actividad['tipo_accion']; ?>: <?php echo htmlspecialchars($actividad['nombre_empleado']); ?></p>
                          <p class="activity-time">
                            <?php 
                              $fecha = new DateTime($actividad['fecha_accion']);
                              $ahora = new DateTime();
                              $intervalo = $fecha->diff($ahora);
                              
                              if ($intervalo->d > 0) {
                                echo 'Hace ' . $intervalo->d . ' día(s)';
                              } elseif ($intervalo->h > 0) {
                                echo 'Hace ' . $intervalo->h . ' hora(s)';
                              } else {
                                echo 'Hace ' . $intervalo->i . ' minuto(s)';
                              }
                            ?>
                          </p>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="activity-item">
                      <div class="activity-content">
                        <p class="activity-title">No hay actividad reciente</p>
                      </div>
                    </div>
                  <?php endif; ?>
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