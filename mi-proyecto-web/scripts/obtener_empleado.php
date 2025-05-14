<?php
// Archivo: scripts/obtener_empleado.php

// Conexión a la base de datos
$host = "localhost";
$usuario = "admin";
$contrasena = "1234";
$basededatos = "ds6";

$conn = new mysqli($host, $usuario, $contrasena, $basededatos);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]));
}

// Verificar si se recibió la cédula
if (!isset($_POST['cedula']) || empty($_POST['cedula'])) {
    die(json_encode(['error' => 'No se recibió la cédula del empleado']));
}

$cedula = $conn->real_escape_string($_POST['cedula']);

// Consulta para obtener todos los datos del empleado
$sql = "SELECT e.*, 
        d.nombre AS departamento_nombre, 
        c.nombre AS cargo_nombre,
        p.nombre_provincia AS provincia_nombre,
        di.nombre_distrito AS distrito_nombre,
        co.nombre_corregimiento AS corregimiento_nombre,
        n.pais AS nacionalidad_nombre
        FROM empleados e 
        LEFT JOIN departamento d ON e.departamento = d.codigo 
        LEFT JOIN cargo c ON e.cargo = c.codigo
        LEFT JOIN provincia p ON e.provincia = p.codigo_provincia
        LEFT JOIN distrito di ON e.distrito = di.codigo_distrito
        LEFT JOIN corregimiento co ON e.corregimiento = co.codigo_corregimiento
        LEFT JOIN nacionalidad n ON e.nacionalidad = n.codigo
        WHERE e.cedula = '$cedula'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $empleado = $result->fetch_assoc();
    
    // Convertir valores numéricos a texto para género y estado civil
    switch ($empleado['genero']) {
        case 0: $empleado['genero_texto'] = 'Femenino'; break;
        case 1: $empleado['genero_texto'] = 'Masculino'; break;
        default: $empleado['genero_texto'] = 'No especificado';
    }
    
    switch ($empleado['estado_civil']) {
        case 0: $empleado['estado_civil_texto'] = 'Soltero/a'; break;
        case 1: $empleado['estado_civil_texto'] = 'Casado/a'; break;
        case 2: $empleado['estado_civil_texto'] = 'Divorciado/a'; break;
        case 3: $empleado['estado_civil_texto'] = 'Viudo/a'; break;
        default: $empleado['estado_civil_texto'] = 'No especificado';
    }
    
    // Devolver los datos en formato JSON
    echo json_encode($empleado);
} else {
    echo json_encode(['error' => 'No se encontró el empleado con la cédula proporcionada']);
}

$conn->close();
?>