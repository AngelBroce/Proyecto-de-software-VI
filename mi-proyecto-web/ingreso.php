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
                                <form action="scripts/main.php" method="post">
                                    <div class="mb-4">
                                        <label for="username" class="form-label">Nombre de Usuario</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4 form-check">
                                        <input type="checkbox" class="form-check-input" id="remember">
                                        <label class="form-check-label" for="remember">Recordar sesión</label>
                                        <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
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