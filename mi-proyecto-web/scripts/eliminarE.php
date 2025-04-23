<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "admin";
$contrasena = "1234";
$basededatos = "ds6";
$conn = new mysqli($host, $usuario, $contrasena, $basededatos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la cédula del empleado a eliminar
$cedula = $_POST['cedula'];

// Paso 1: Obtener los datos del empleado usando la cédula
$sql = "SELECT * FROM empleados WHERE cedula = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cedula);
$stmt->execute();
$result = $stmt->get_result();
$empleado = $result->fetch_assoc();

// Verificar si el empleado existe
if ($empleado) {
    // Paso 2: Insertar los datos del empleado en la tabla empleados_eliminados
    $sql_insert = "INSERT INTO e_eliminados (
        cedula, prefijo, tomo, asiento, nombre1, nombre2, apellido1, apellido2, apellidoc,
        genero, estado_civil, tipo_sangre, usa_ac, f_nacimiento, celular, telefono, correo, contraseña,
        provincia, distrito, corregimiento, calle, casa, comunidad, nacionalidad, f_contra, cargo,
        departamento, estado
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param(
        "sssssssssssssssssssssssssssss",
        $empleado['cedula'], $empleado['prefijo'], $empleado['tomo'], $empleado['asiento'], $empleado['nombre1'],
        $empleado['nombre2'], $empleado['apellido1'], $empleado['apellido2'], $empleado['apellidoc'], $empleado['genero'],
        $empleado['estado_civil'], $empleado['tipo_sangre'], $empleado['usa_ac'], $empleado['f_nacimiento'], $empleado['celular'],
        $empleado['telefono'], $empleado['correo'], $empleado['contraseña'], $empleado['provincia'], $empleado['distrito'],
        $empleado['corregimiento'], $empleado['calle'], $empleado['casa'], $empleado['comunidad'], $empleado['nacionalidad'],
        $empleado['f_contra'], $empleado['cargo'], $empleado['departamento'], $empleado['estado']
    );
    $stmt_insert->execute();

    // Paso 3: Actualizar el estado del empleado a "inactivo" en la tabla empleados
    $sql_update = "UPDATE empleados SET estado = 'inactivo' WHERE cedula = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("s", $cedula);
    $stmt_update->execute();

    // Verificación de éxito
    if ($stmt_insert->affected_rows > 0 && $stmt_update->affected_rows > 0) {
        echo "Empleado marcado como inactivo y movido a la tabla de empleados eliminados.";
    } else {
        echo "Error al actualizar el estado del empleado.";
    }

    $stmt_insert->close();
    $stmt_update->close();
} else {
    echo "Empleado no encontrado.";
}

$stmt->close();
$conn->close();
?>
