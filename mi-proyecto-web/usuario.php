<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'admin', '1234', 'ds6');

if ($conn->connect_error) {
    die('<div class="alert alert-danger">Error de conexión: ' . $conn->connect_error . '</div>');
}

// Obtener información del empleado
// Si viene de POST (formulario de login), usar esos datos
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Verificar credenciales y obtener cédula
    $sqlUsuario = "SELECT cedula FROM usuarios WHERE correo_institucional = ? AND contraseña = ?";
    $stmtUsuario = $conn->prepare($sqlUsuario);
    $stmtUsuario->bind_param('ss', $email, $password);
    $stmtUsuario->execute();
    $resultUsuario = $stmtUsuario->get_result();
    
    if ($resultUsuario->num_rows > 0) {
        $rowUsuario = $resultUsuario->fetch_assoc();
        $cedula = $rowUsuario['cedula'];
        $_SESSION['cedula'] = $cedula; // Guardar en sesión para futuras páginas
    } else {
        // Si no se encuentran credenciales, mostrar error
        echo '<div class="alert alert-danger">Credenciales incorrectas.</div>';
        // No redirigir, permitir que la página se cargue con el mensaje de error
    }
} 
// Si no viene de POST, intentar usar la cédula de la sesión
elseif (isset($_SESSION['cedula'])) {
    $cedula = $_SESSION['cedula'];
} 
// Si no hay ni POST ni sesión, mostrar un formulario de login simple
else {
    // Mostrar un formulario de login simple en la misma página
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión - StaffLink</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="styles/LogIn-styles.css">
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-4">Iniciar Sesión</h2>
                            <form action="usuario.php" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Institucional</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Ingresar</button>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="ingreso.php" class="text-decoration-none">Volver a la página principal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit; // Detener la ejecución después de mostrar el formulario
}

// Si llegamos aquí, tenemos una cédula (de POST o de sesión)
// Consultar la información del empleado
$sqlEmpleado = "SELECT e.*, c.nombre as cargo_nombre, d.nombre as departamento_nombre, 
                p.nombre_provincia, di.nombre_distrito, co.nombre_corregimiento, n.pais as nacionalidad_nombre
                FROM empleados e
                LEFT JOIN cargo c ON e.cargo = c.codigo
                LEFT JOIN departamento d ON e.departamento = d.codigo
                LEFT JOIN provincia p ON e.provincia = p.codigo_provincia
                LEFT JOIN distrito di ON e.distrito = di.codigo_distrito AND e.provincia = di.codigo_provincia
                LEFT JOIN corregimiento co ON e.corregimiento = co.codigo_corregimiento
                LEFT JOIN nacionalidad n ON e.nacionalidad = n.codigo
                WHERE e.cedula = ?";

$stmt = $conn->prepare($sqlEmpleado);
$stmt->bind_param('s', $cedula);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    // Si no se encuentra el empleado, mostrar error
    echo '<div class="alert alert-danger">No se encontró información del empleado.</div>';
    exit;
}

$empleado = $resultado->fetch_assoc();

// Formatear nombre completo
$nombreCompleto = $empleado['nombre1'];
if (!empty($empleado['nombre2'])) $nombreCompleto .= ' ' . $empleado['nombre2'];
$nombreCompleto .= ' ' . $empleado['apellido1'];
if (!empty($empleado['apellido2'])) $nombreCompleto .= ' ' . $empleado['apellido2'];
if (!empty($empleado['apellidoc'])) $nombreCompleto .= ' de ' . $empleado['apellidoc'];

// Formatear género
$genero = $empleado['genero'] == 0 ? 'Masculino' : 'Femenino';

// Formatear estado civil
$estadoCivil = '';
switch ($empleado['estado_civil']) {
    case 1: $estadoCivil = 'Soltero(a)'; break;
    case 2: $estadoCivil = 'Casado(a)'; break;
    case 3: $estadoCivil = 'Divorciado(a)'; break;
    case 4: $estadoCivil = 'Viudo(a)'; break;
    default: $estadoCivil = 'No especificado';
}

// Formatear dirección completa
$direccionCompleta = '';
if (!empty($empleado['nombre_provincia'])) $direccionCompleta .= $empleado['nombre_provincia'];
if (!empty($empleado['nombre_distrito'])) $direccionCompleta .= ', ' . $empleado['nombre_distrito'];
if (!empty($empleado['nombre_corregimiento'])) $direccionCompleta .= ', ' . $empleado['nombre_corregimiento'];
if (!empty($empleado['calle'])) $direccionCompleta .= ', ' . $empleado['calle'];
if (!empty($empleado['casa'])) $direccionCompleta .= ', Casa ' . $empleado['casa'];
if (!empty($empleado['comunidad'])) $direccionCompleta .= ', ' . $empleado['comunidad'];

// Calcular edad
$fechaNacimiento = new DateTime($empleado['f_nacimiento']);
$hoy = new DateTime();
$edad = $hoy->diff($fechaNacimiento)->y;

// Calcular tiempo en la empresa
$fechaContratacion = new DateTime($empleado['f_contra']);
$tiempoEmpresa = $hoy->diff($fechaContratacion);
$tiempoEmpresaTexto = '';
if ($tiempoEmpresa->y > 0) {
    $tiempoEmpresaTexto .= $tiempoEmpresa->y . ' año(s) ';
}
if ($tiempoEmpresa->m > 0) {
    $tiempoEmpresaTexto .= $tiempoEmpresa->m . ' mes(es) ';
}
if ($tiempoEmpresa->d > 0) {
    $tiempoEmpresaTexto .= $tiempoEmpresa->d . ' día(s)';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Empleado - StaffLink</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="styles/LogIn-styles.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f97316;
            --light-bg: #f9fafb;
            --card-bg: #ffffff;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-color: #e5e7eb;
        }

        body {
            background-color: var(--light-bg);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .profile-header {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stats-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
        }

        .bg-primary-light {
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        .bg-success-light {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .bg-warning-light {
            background-color: rgba(249, 115, 22, 0.1);
            color: var(--secondary-color);
        }

        .bg-info-light {
            background-color: rgba(6, 182, 212, 0.1);
            color: #06b6d4;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin-right: 20px;
        }

        .info-label {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: 500;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
        }

        .sidebar {
            width: 280px;
            background-color: #1e293b;
            color: white;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logo-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            margin-right: 10px;
        }

        .sidebar-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-nav {
            flex: 1;
        }

        .nav-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            padding: 0 20px;
            margin: 15px 0 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-item:hover, .nav-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-info {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .small-text {
            font-size: 0.75rem;
            margin-top: 5px;
        }

        .calendar-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .calendar-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
        }

        .calendar-nav button {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-light);
            padding: 5px 0;
        }

        .calendar-day {
            text-align: center;
            padding: 8px 0;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .calendar-day:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }

        .calendar-day.today {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .calendar-day.other-month {
            color: var(--text-light);
            opacity: 0.5;
        }

        @media (max-width: 992px) {
            .dashboard-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                padding: 10px 0;
            }
            
            .profile-header {
                flex-direction: column;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 20px;
            }
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
                <div class="nav-category">Principal</div>
                <a href="#" class="nav-item active">
                    <i class="bi bi-house-door"></i>
                    <span>Inicio</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="bi bi-person"></i>
                    <span>Mi Perfil</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="bi bi-calendar-event"></i>
                    <span>Calendario</span>
                </a>
                
                <div class="nav-category">Recursos</div>
                <a href="#" class="nav-item">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Documentos</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="bi bi-chat-dots"></i>
                    <span>Mensajes</span>
                </a>
                
                <div class="nav-category">Sistema</div>
                <a href="#" class="nav-item">
                    <i class="bi bi-gear"></i>
                    <span>Configuración</span>
                </a>
                <a href="ingreso.php" class="nav-item">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="sidebar-info">
                    <p>Sistema de gestión de empleados</p>
                    <p class="small-text">Versión 1.0.2</p>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- Header -->
                <div class="profile-header d-flex align-items-center mb-4">
                    <div class="profile-avatar">
                        <?php echo strtoupper(substr($empleado['nombre1'], 0, 1) . substr($empleado['apellido1'], 0, 1)); ?>
                    </div>
                    <div>
                        <h2 class="mb-1">Buen día, <?php echo $empleado['nombre1']; ?></h2>
                        <p class="text-muted mb-0">
                            <?php echo $empleado['cargo_nombre']; ?> | <?php echo $empleado['departamento_nombre']; ?>
                        </p>
                        <p class="text-muted mb-2">
                            <?php echo date('l, d \d\e F Y'); ?>
                        </p>
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stats-card d-flex align-items-center">
                            <div class="icon bg-primary-light">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <h6 class="mb-0"><?php echo $edad; ?> años</h6>
                                <p class="text-muted mb-0">Edad</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stats-card d-flex align-items-center">
                            <div class="icon bg-success-light">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <div>
                                <h6 class="mb-0"><?php echo $tiempoEmpresaTexto; ?></h6>
                                <p class="text-muted mb-0">En la empresa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stats-card d-flex align-items-center">
                            <div class="icon bg-warning-light">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <h6 class="mb-0"><?php echo $empleado['departamento_nombre']; ?></h6>
                                <p class="text-muted mb-0">Departamento</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stats-card d-flex align-items-center">
                            <div class="icon bg-info-light">
                                <i class="bi bi-droplet"></i>
                            </div>
                            <div>
                                <h6 class="mb-0"><?php echo $empleado['tipo_sangre']; ?></h6>
                                <p class="text-muted mb-0">Tipo de sangre</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Información Personal -->
                    <div class="col-lg-8 mb-4">
                        <div class="profile-card">
                            <h3 class="section-title">Información Personal</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="info-label">Nombre Completo</div>
                                        <div class="info-value"><?php echo $nombreCompleto; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Cédula</div>
                                        <div class="info-value"><?php echo $empleado['cedula']; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Fecha de Nacimiento</div>
                                        <div class="info-value"><?php echo date('d/m/Y', strtotime($empleado['f_nacimiento'])); ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Género</div>
                                        <div class="info-value"><?php echo $genero; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="info-label">Estado Civil</div>
                                        <div class="info-value"><?php echo $estadoCivil; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Nacionalidad</div>
                                        <div class="info-value"><?php echo $empleado['nacionalidad_nombre']; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Tipo de Sangre</div>
                                        <div class="info-value"><?php echo $empleado['tipo_sangre']; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Usa Anteojos</div>
                                        <div class="info-value"><?php echo $empleado['usa_ac'] ? 'Sí' : 'No'; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de Contacto -->
                        <div class="profile-card">
                            <h3 class="section-title">Información de Contacto</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="info-label">Correo Electrónico</div>
                                        <div class="info-value"><?php echo $empleado['correo']; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Teléfono Celular</div>
                                        <div class="info-value"><?php echo $empleado['celular']; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="info-label">Teléfono Fijo</div>
                                        <div class="info-value"><?php echo $empleado['telefono'] ? $empleado['telefono'] : 'No registrado'; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Dirección</div>
                                        <div class="info-value"><?php echo $direccionCompleta; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información Laboral -->
                        <div class="profile-card">
                            <h3 class="section-title">Información Laboral</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="info-label">Cargo</div>
                                        <div class="info-value"><?php echo $empleado['cargo_nombre']; ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Departamento</div>
                                        <div class="info-value"><?php echo $empleado['departamento_nombre']; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="info-label">Fecha de Contratación</div>
                                        <div class="info-value"><?php echo date('d/m/Y', strtotime($empleado['f_contra'])); ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="info-label">Estado</div>
                                        <div class="info-value">
                                            <?php if ($empleado['estado'] == 1): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactivo</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Calendario y Acciones Rápidas -->
                    <div class="col-lg-4">
                        <div class="calendar-card mb-4">
                            <div class="calendar-header">
                                <div class="calendar-title">Mayo 2025</div>
                                <div class="calendar-nav">
                                    <button><i class="bi bi-chevron-left"></i></button>
                                    <button><i class="bi bi-chevron-right"></i></button>
                                </div>
                            </div>
                            <div class="calendar-grid">
                                <div class="calendar-day-header">Lu</div>
                                <div class="calendar-day-header">Ma</div>
                                <div class="calendar-day-header">Mi</div>
                                <div class="calendar-day-header">Ju</div>
                                <div class="calendar-day-header">Vi</div>
                                <div class="calendar-day-header">Sa</div>
                                <div class="calendar-day-header">Do</div>
                                
                                <div class="calendar-day other-month">28</div>
                                <div class="calendar-day other-month">29</div>
                                <div class="calendar-day other-month">30</div>
                                <div class="calendar-day">1</div>
                                <div class="calendar-day">2</div>
                                <div class="calendar-day">3</div>
                                <div class="calendar-day">4</div>
                                
                                <div class="calendar-day">5</div>
                                <div class="calendar-day">6</div>
                                <div class="calendar-day">7</div>
                                <div class="calendar-day">8</div>
                                <div class="calendar-day">9</div>
                                <div class="calendar-day">10</div>
                                <div class="calendar-day">11</div>
                                
                                <div class="calendar-day">12</div>
                                <div class="calendar-day">13</div>
                                <div class="calendar-day">14</div>
                                <div class="calendar-day today">15</div>
                                <div class="calendar-day">16</div>
                                <div class="calendar-day">17</div>
                                <div class="calendar-day">18</div>
                                
                                <div class="calendar-day">19</div>
                                <div class="calendar-day">20</div>
                                <div class="calendar-day">21</div>
                                <div class="calendar-day">22</div>
                                <div class="calendar-day">23</div>
                                <div class="calendar-day">24</div>
                                <div class="calendar-day">25</div>
                                
                                <div class="calendar-day">26</div>
                                <div class="calendar-day">27</div>
                                <div class="calendar-day">28</div>
                                <div class="calendar-day">29</div>
                                <div class="calendar-day">30</div>
                                <div class="calendar-day">31</div>
                                <div class="calendar-day other-month">1</div>
                            </div>
                        </div>
                        
                        <div class="profile-card">
                            <h3 class="section-title">Acciones Rápidas</h3>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary">
                                    <i class="bi bi-file-earmark-text me-2"></i> Solicitar Documento
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-calendar-plus me-2"></i> Solicitar Permiso
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-chat-dots me-2"></i> Enviar Mensaje
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-pencil-square me-2"></i> Actualizar Información
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
