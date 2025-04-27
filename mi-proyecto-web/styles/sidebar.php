<!-- filepath: c:\xampp\htdocs\WEB\Proyecto-de-software-VI\mi-proyecto-web\sidebar.php -->
<div class="sidebar">
  <div class="sidebar-header">
    <div class="logo-circle"></div>
    <h1 class="sidebar-title">StaffLink</h1>
  </div>
  
  <nav class="sidebar-nav">
    <div class="nav-category">General</div>
    <a href="index.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>

    <a href="Gestion.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'gestionar_empleados.php' ? 'active' : '' ?>">
      <i class="bi bi-people"></i>
      <span>Gestionar Empleados</span>
    </a>
    <a href="creacionU.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'creacionU.php' ? 'active' : '' ?>">
      <i class="bi bi-person-plus"></i>
      <span>Añadir Empleado</span>
    </a>
  </nav>
  
  <div class="sidebar-footer">
    <a href="ingreso.php" class="nav-item">
      <i class="bi bi-box-arrow-right"></i>
      <span>Cerrar sesión</span>
    </a>
  </div>
</div>