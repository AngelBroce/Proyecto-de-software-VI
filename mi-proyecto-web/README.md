# StaffLink - Sistema de Gestión de Recursos Humanos

## Introducción y visión general

### Descripción breve de la aplicación
StaffLink es un sistema de gestión de recursos humanos diseñado para administrar información de empleados, departamentos y cargos en una organización. Permite el registro, visualización y gestión de datos de personal, con diferentes niveles de acceso según el rol del usuario.

### Propósito y objetivos del sistema
- Centralizar la gestión de empleados y su información laboral
- Permitir el seguimiento del estado de los empleados (activos/inactivos)
- Ofrecer un dashboard con estadísticas relevantes para la toma de decisiones
- Facilitar la administración de departamentos y cargos

### Audiencia objetivo de la documentación
Esta documentación está dirigida a desarrolladores, administradores de sistemas y personal técnico que necesite implementar, mantener o extender la funcionalidad del sistema StaffLink.

## Arquitectura del sistema

### Diagrama de arquitectura
```
+------------------+     +------------------+     +------------------+
| Interfaz de      |     | Lógica de        |     | Base de Datos    |
| Usuario(Frontend)|<--->| Negocio (PHP)    |<--->| MySQL (ds6)      |
+------------------+     +------------------+     +------------------+
         |                       |                        |
         v                       v                        v
+------------------+     +------------------+     +------------------+
| Bootstrap 5      |     | Módulos:         |     | Tablas:          |
| HTML/CSS/JS      |     | - Autenticación  |     | - empleados      |
| jQuery           |     | - Empleados      |     | - usuarios       |
|                  |     | - Departamentos  |     | - departamento   |
|                  |     | - Cargos         |     | - cargo          |
+------------------+     +------------------+     +------------------+
```

### Descripción de componentes principales
- **Frontend**: Interfaz responsiva desarrollada con Bootstrap 5, HTML5, CSS3 y JavaScript
- **Backend**: Aplicación PHP que maneja la lógica de negocio y la comunicación con la base de datos
- **Base de datos**: Sistema MySQL que almacena toda la información del sistema

### Patrones de diseño implementados
- **MVC simplificado**: Separación parcial entre la presentación (vistas PHP/HTML) y la lógica (PHP)
- **DAO**: Funciones específicas para el acceso a datos en la base de datos
- **Singleton**: Patrón de conexión única a la base de datos

### Flujo de datos e interacciones entre componentes
1. El usuario interactúa con la interfaz web
2. Las solicitudes se procesan mediante PHP
3. La lógica de negocio valida y procesa los datos
4. Se realizan consultas a la base de datos MySQL
5. Los resultados se devuelven a la capa de presentación
6. La interfaz muestra la información al usuario

## Stack tecnológico

### Lenguajes de programación utilizados
- PHP 7.x/8.x (backend)
- JavaScript ES6 (frontend)
- SQL (consultas a base de datos)
- HTML5/CSS3 (estructura y estilos)

### Frameworks y bibliotecas
- Bootstrap 5 (framework CSS)
- jQuery 3.4 (biblioteca JavaScript)
- Bootstrap Icons (iconografía)

### Bases de datos y sistemas de persistencia
- MySQL 5.x/8.x
- Estructura relacional con tablas normalizada

### Servicios externos integrados
No se identifican servicios externos en la actual versión del sistema.

## Requisitos del sistema

### Hardware recomendado
- Procesador: 2 GHz o superior
- RAM: 4 GB o superior
- Disco duro: 10 GB de espacio libre

### Software necesario y dependencias
- Servidor web: Apache 2.4 o superior
- PHP: Versión 7.4 o superior
- MySQL: Versión 5.7 o superior
- Navegador web moderno (Chrome, Firefox, Edge, Safari)

### Configuración del entorno
- Configurar servidor web para ejecutar PHP
- Asegurar soporte para extensiones mysqli de PHP
- Habilitar sesiones PHP

## Guía de instalación

### Pasos detallados para configurar el entorno de desarrollo
1. Instalar XAMPP, WAMP, MAMP o un servidor similar que incluya Apache, PHP y MySQL
2. Clonar el repositorio en el directorio htdocs (XAMPP) o www (WAMP)
3. Importar el archivo de base de datos (no incluido) a MySQL
4. Configurar las credenciales de acceso a la base de datos en `scripts/main.php`
5. Acceder a través del navegador: `http://localhost/mi-proyecto-web/`

### Instrucciones para despliegue en producción
1. Configurar un servidor web con PHP y MySQL
2. Asegurar la configuración de SSL para conexiones seguras
3. Transferir los archivos del proyecto al servidor
4. Configurar la base de datos en el servidor
5. Actualizar las credenciales de base de datos en los archivos de configuración
6. Establecer permisos adecuados para directorios y archivos
7. Realizar pruebas de seguridad y funcionamiento

### Solución a problemas comunes de instalación
- **Error de conexión a base de datos**: Verificar credenciales en `scripts/main.php`
- **Problemas de permisos**: Asegurar que los archivos tengan permisos de lectura y ejecución adecuados
- **Error 500**: Revisar el registro de errores del servidor web

## Configuración

### Variables de entorno
El sistema no utiliza variables de entorno, pero puede ser adaptado para implementarlas.

### Archivos de configuración
- **scripts/main.php**: Contiene la configuración de conexión a la base de datos y funciones principales
- **styles/sidebar.php**: Configuración del menú lateral y navegación

### Opciones personalizables
- Credenciales de base de datos
- Elementos visuales mediante archivos CSS
- Comportamiento de filtros y búsquedas

## Estructura del código

### Organización de directorios y archivos
```
mi-proyecto-web/
├── index.php           # Dashboard principal
├── Gestion.php         # Gestión de empleados
├── usuario.php         # Vista de usuario regular
├── creacionU.php       # Creación/edición de empleados
├── visualizacion.php   # Visualización detallada de empleado
├── ingreso-fix.php     # Página de inicio de sesión
├── scripts/
│   └── main.php        # Funciones principales y conexión BD
├── styles/
│   ├── styles.css      # Estilos principales
│   ├── LogIn-styles.css # Estilos de login
│   ├── Gestion-styles.css # Estilos de gestión
│   └── sidebar.php     # Componente de barra lateral
└── jquery3-4.min.js    # Biblioteca jQuery
```

### Convenciones de nomenclatura
- Archivos: CamelCase para páginas principales, minúsculas para componentes
- Funciones PHP: camelCase
- Variables: camelCase
- Consultas SQL: Palabras clave en mayúsculas, nombres de tablas y columnas en minúsculas

### Patrones utilizados
- Autenticación basada en sesiones
- Consultas preparadas para prevenir inyección SQL
- Componentes reutilizables (sidebar)
- Validación de entradas en el lado del servidor

## API y endpoints

### Documentación de APIs
El sistema implementa una mini-API interna basada en PHP para operaciones AJAX:

### Métodos, parámetros y respuestas
- **getProvincias**: Devuelve todas las provincias
- **getDistritos**: Parámetro: `provincias` (ID), Devuelve distritos por provincia
- **getCorregimientos**: Parámetro: `distritos` (ID), Devuelve corregimientos por distrito
- **getNacionalidades**: Devuelve todas las nacionalidades
- **getDepartamentos**: Devuelve todos los departamentos
- **getCargosPorDepartamento**: Parámetro: `departamento` (ID), Devuelve cargos por departamento

### Ejemplos de uso
```javascript
// Ejemplo de llamada AJAX para obtener departamentos
$.ajax({
    url: 'scripts/main.php',
    type: 'POST',
    data: { action: 'getDepartamentos' },
    dataType: 'json',
    success: function(response) {
        // Procesar departamentos
    }
});
```

## Guía de uso

### Funcionalidades principales
- **Dashboard**: Visualización de estadísticas y registros recientes
- **Gestión de Empleados**: CRUD completo para datos de empleados
- **Filtros y búsquedas**: Por departamento, estado, nombre, etc.
- **Autenticación**: Diferentes niveles de acceso según rol

### Flujos de trabajo típicos
1. **Ingreso al sistema**: Autenticación de usuario
2. **Consulta de empleados**: Visualización de listados y filtrado
3. **Creación de empleado**: Registro de datos personales y laborales
4. **Gestión de departamentos/cargos**: Administración de catálogos

### Escenarios de uso comunes
- Administrador consultando estadísticas en el Dashboard
- Recursos Humanos registrando un nuevo empleado
- Búsqueda y filtrado de empleados por departamento
- Cambio de estado de un empleado (activo/inactivo)

## Mantenimiento

### Procedimientos de backup
Recomendaciones:
- Respaldo periódico de la base de datos MySQL
- Backup de los archivos del proyecto
- Almacenamiento en ubicación segura (preferiblemente externa)

### Monitoreo
- Revisar logs de errores de PHP y del servidor web
- Monitorear espacio en disco y rendimiento de la base de datos
- Verificar integridad de datos periódicamente

### Actualización del sistema
1. Realizar respaldo completo antes de actualizar
2. Aplicar cambios en entorno de desarrollo primero
3. Probar exhaustivamente las nuevas funcionalidades
4. Desplegar en producción siguiendo protocolo de cambios
5. Verificar funcionamiento post-actualización