<?php
// scripts/actualizar_empleado.php

// Conexión a la base de datos
$host = "localhost";
$usuario = "admin";
$contrasena = "1234";
$basededatos = "ds6";

$conn = new mysqli($host, $usuario, $contrasena, $basededatos);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexión fallida: ' . $conn->connect_error]));
}

// Verificar si se recibieron los datos
if (!isset($_POST['cedula']) || empty($_POST['cedula'])) {
    die(json_encode(['error' => 'No se recibió la cédula del empleado']));
}

// Obtener datos del formulario
$cedula = $conn->real_escape_string($_POST['cedula']);
$nombre1 = $conn->real_escape_string($_POST['nombre1']);
$nombre2 = $conn->real_escape_string($_POST['nombre2']);
$apellido1 = $conn->real_escape_string($_POST['apellido1']);
$apellido2 = $conn->real_escape_string($_POST['apellido2']);
$correo = $conn->real_escape_string($_POST['correo']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$celular = $conn->real_escape_string($_POST['celular']);
$departamento = $conn->real_escape_string($_POST['departamento']);
$cargo = $conn->real_escape_string($_POST['cargo']);
$estado = $conn->real_escape_string($_POST['estado']);
$calle = $conn->real_escape_string($_POST['calle']);
$casa = $conn->real_escape_string($_POST['casa']);
$comunidad = $conn->real_escape_string($_POST['comunidad']);

// Asegurar que los números de teléfono y celular no contengan guiones
$telefono = preg_replace('/[^0-9]/', '', $telefono);
$celular = preg_replace('/[^0-9]/', '', $celular);

// Actualizar la información del empleado
$sql = "UPDATE empleados SET 
        nombre1 = '$nombre1',
        nombre2 = '$nombre2',
        apellido1 = '$apellido1',
        apellido2 = '$apellido2',
        correo = '$correo',
        telefono = '$telefono',
        celular = '$celular',
        departamento = '$departamento',
        cargo = '$cargo',
        estado = '$estado',
        calle = '$calle',
        casa = '$casa',
        comunidad = '$comunidad'
        WHERE cedula = '$cedula'";

if ($conn->query($sql) === TRUE) {
    // También actualizar la tabla de usuarios si existe
    $sql_usuario = "UPDATE usuarios SET 
                    correo_institucional = '$correo'
                    WHERE cedula = '$cedula'";
    $conn->query($sql_usuario); // No importa si falla, es secundario
    
    echo json_encode(['success' => true, 'message' => 'Información actualizada correctamente']);
} else {
    echo json_encode(['error' => 'Error al actualizar la información: ' . $conn->error]);
}

$conn->close();
?>