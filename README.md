# Proyecto-de-software-VI

/empleados-gestion
│
├── /assets              # Archivos de recursos estáticos
│   ├── /css             # Estilos CSS
│   │   ├── style.css    # Archivo principal de estilos
│   │   
│   ├── /img             # Imágenes de la aplicación
│   └── /js              # Scripts JavaScript
│       └── app.js       # Script principal de la aplicación
│
├── /config              # Configuración del sistema
│   ├── BDD.sql          # Configuración de la base de datos
│   └── auth_config.php  # Configuración de autenticación y roles de usuario
│
├── /includes            # Archivos PHP comunes
│   └── functions.php    # Funciones generales de la aplicación (validaciones, redirecciones, etc.)
│
├── /public              # Archivos accesibles públicamente
│   ├── /login           # Pantalla de inicio de sesión
│   │   └── login.php    # Vista de login
│   ├── /dashboard       # Pantalla principal después de loguearse
│   │   └── index.php    # Vista principal para la gestión de empleados
│   ├── /employees       # Vista para gestionar empleados
│   │   ├── add_employee.php   # Formulario para agregar nuevos empleados
│   │   ├── edit_employee.php  # Formulario para editar la información de un empleado
│   │   └── delete_employee.php # Acción para eliminar un empleado
│   └── /profile         # Perfil de un empleado
│       └── profile.php  # Vista para mostrar y editar la información personal de un empleado
│
└── /scripts             # Scripts PHP que realizan las operaciones (CRUD)
    ├── add_employee.php     # Lógica para agregar empleados
    ├── edit_employee.php    # Lógica para editar empleados
    ├── delete_employee.php  # Lógica para eliminar empleados
    ├── login.php            # Lógica para iniciar sesión
    ├── logout.php           # Lógica para cerrar sesión
    └── authenticate.php     # Lógica para autenticar usuarios
