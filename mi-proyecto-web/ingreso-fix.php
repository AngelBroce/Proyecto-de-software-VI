<?php
session_start(); // Asegurarse de iniciar la sesión al principio

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'admin', '1234', 'ds6');

    if ($conn->connect_error) {
        die('<div class="alert alert-danger">Error de conexión: ' . $conn->connect_error . '</div>');
    }

    // Verificar cédula en la tabla usuarios
    $sqlUsuario = "SELECT cedula FROM usuarios WHERE correo_institucional = ? AND contraseña = ?";
    $stmtUsuario = $conn->prepare($sqlUsuario);

    if (!$stmtUsuario) {
        die('<div class="alert alert-danger">Error en la preparación de la consulta: ' . $conn->error . '</div>');
    }

    $stmtUsuario->bind_param('ss', $email, $password);
    $stmtUsuario->execute();
    $resultUsuario = $stmtUsuario->get_result();

    if ($resultUsuario === false) {
        die('<div class="alert alert-danger">Error en la ejecución de la consulta: ' . $stmtUsuario->error . '</div>');
    }

    if ($resultUsuario->num_rows > 0) {
        $rowUsuario = $resultUsuario->fetch_assoc();
        $cedula = $rowUsuario['cedula'];
        
        // Guardar la cédula en la sesión
        $_SESSION['cedula'] = $cedula;

        // Buscar el cargo en la tabla empleados
        $sqlEmpleado = "SELECT cargo FROM empleados WHERE cedula = ? AND cargo = '0101'";
        $stmtEmpleado = $conn->prepare($sqlEmpleado);

        if (!$stmtEmpleado) {
            die('<div class="alert alert-danger">Error en la preparación de la consulta: ' . $conn->error . '</div>');
        }

        $stmtEmpleado->bind_param('s', $cedula);
        $stmtEmpleado->execute();
        $resultEmpleado = $stmtEmpleado->get_result();

        if ($resultEmpleado === false) {
            die('<div class="alert alert-danger">Error en la ejecución de la consulta: ' . $stmtEmpleado->error . '</div>');
        }

        if ($resultEmpleado->num_rows > 0) {
            // Es administrador
            $_SESSION['es_admin'] = true;
            echo "<script>alert('¡Registro exitoso!'); window.location.href = 'index.php';</script>";
            exit;
        } else {
            // No es administrador
            $_SESSION['es_admin'] = false;
            echo "<script>alert('Redirigiendo a usuario.'); window.location.href = 'usuario.php';</script>";
            exit;
        }

        $stmtEmpleado->close();
    } else {
        echo '<div class="alert alert-danger">Credenciales incorrectas.</div>';
    }

    $stmtUsuario->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso - Mi Proyecto Web</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="styles/LogIn-styles.css">
    <!-- Sidebar -->
</head>
<body>
    <div class="login-container">
        
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo-circle"></div>
                <h1 class="sidebar-title">StaffLink</h1>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-category">Acceso</div>
                <a href="#" class="nav-item active">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Iniciar Sesión</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="bi bi-question-circle"></i>
                    <span>Ayuda</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="sidebar-info">
                    <p>Bienvenido al sistema de gestión</p>
                    <p class="small-text">Versión 1.0.2</p>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row justify-content-center align-items-center min-vh-100">
                    <div class="col-md-8 col-lg-6">
                        <!-- Login Card -->
                        <div class="auth-card">
                            <div class="auth-header">
                                <h2>Ingreso al Sistema</h2>
                                <p>Ingresa tus credenciales para acceder</p>
                            </div>
                            
                            <div class="auth-body">
                                <form action="" method="post">
                                    <div class="mb-4">
                                        <label for="email" class="form-label">Correo Institucional</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Ingresar</button>
                                    </div>
                                </form>
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
