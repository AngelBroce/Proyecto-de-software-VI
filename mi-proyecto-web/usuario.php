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
    <link rel="stylesheet" href="styles/User-styles.css">
    
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
                <a href="#" class="nav-item active">
                    <i class="bi bi-person"></i>
                    <span>Mi Perfil</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="ingreso-fix.php" class="nav-item">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Cerrar Sesión</span>
                </a>
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
                                        <div class="info-label">Usa Apellido de Casada</div>
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
