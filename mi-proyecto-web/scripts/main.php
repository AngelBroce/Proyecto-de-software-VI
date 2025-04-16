<?php
// Configuración de la conexión
$host = "localhost"; // Cambia esto si tu servidor no es localhost
$user = "admin"; // Usuario de la base de datos
$password = "1234"; // Contraseña de la base de datos
$dbname = "ds6"; // Cambia esto por el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

// Manejar solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON

    // Obtener provincias
    if (isset($_POST['action']) && $_POST['action'] === 'getProvincias') {
        obtenerProvincias($conn);
        exit;
    }

    // Obtener distritos según la provincia
    if (isset($_POST['provincias'])) {
        $provinciaId = $conn->real_escape_string($_POST['provincias']);
        if (!ctype_digit($provinciaId)) {
            echo json_encode(["error" => "ID de provincia inválido"]);
            exit;
        }
        obtenerDistritos($conn, $provinciaId);
        exit;
    }

    // Obtener corregimientos según el distrito
    if (isset($_POST['distritos'])) {
        $distritoId = $conn->real_escape_string($_POST['distritos']);
        if (!ctype_digit($distritoId)) {
            echo json_encode(["error" => "ID de distrito inválido"]);
            exit;
        }
        obtenerCorregimientos($conn, $distritoId);
        exit;
    }

    // Obtener nacionalidades
    if (isset($_POST['action']) && $_POST['action'] === 'getNacionalidades') {
        obtenerNacionalidades($conn);
        exit;
    }
}

// Función para obtener provincias
function obtenerProvincias($conn) {
    $query = "SELECT codigo_provincia AS codigo, nombre_provincia AS nombre FROM provincia";
    $result = $conn->query($query);

    if (!$result) {
        echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
        return;
    }

    $provincias = [];
    while ($row = $result->fetch_assoc()) {
        $provincias[] = [
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre']
        ];
    }

    echo json_encode(['provincias' => $provincias]);
}

// Función para obtener distritos
function obtenerDistritos($conn, $provinciaId) {
    $query = "SELECT codigo_distrito AS codigo, nombre_distrito AS nombre FROM distrito WHERE codigo_provincia = '$provinciaId'";
    $result = $conn->query($query);

    if (!$result) {
        echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
        return;
    }

    $distritos = [];
    while ($row = $result->fetch_assoc()) {
        $distritos[] = [
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre']
        ];
    }

    echo json_encode(['distritos' => $distritos]);
}

// Función para obtener corregimientos
function obtenerCorregimientos($conn, $distritoId) {
    $query = "SELECT codigo_corregimiento AS codigo, nombre_corregimiento AS nombre FROM corregimiento WHERE codigo_distrito = '$distritoId'";
    $result = $conn->query($query);

    if (!$result) {
        echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
        return;
    }

    $corregimientos = [];
    while ($row = $result->fetch_assoc()) {
        $corregimientos[] = [
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre']
        ];
    }

    echo json_encode(['corregimiento' => $corregimientos]);
}

// Función para obtener nacionalidades
function obtenerNacionalidades($conn) {
    $query = "SELECT id AS codigo, nombre AS nombre FROM paises";
    $result = $conn->query($query);

    if (!$result) {
        echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
        return;
    }

    $nacionalidades = [];
    while ($row = $result->fetch_assoc()) {
        $nacionalidades[] = [
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre']
        ];
    }

    // Asegurar que Panamá esté al inicio de la lista
    usort($nacionalidades, function($a, $b) {
        return $a['nombre'] === 'Panamá' ? -1 : 1;
    });

    echo json_encode(['nacionalidades' => $nacionalidades]);
}

// Cerrar la conexión
//$conn->close();
?>