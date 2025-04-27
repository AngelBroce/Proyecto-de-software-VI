<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "admin";
$contrasena = "1234";
$basededatos = "ds6";

// Ajustar configuraciones de MySQL
ini_set('mysqli.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

$conn = new mysqli($host, $usuario, $contrasena, $basededatos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la cédula del empleado a eliminar
$cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';

// Verificar si la cédula está llegando correctamente
if (empty($cedula)) {
    error_log("Cédula no proporcionada o vacía.");
    echo "Error: No se recibió la cédula del empleado.";
    exit;
} else {
    error_log("Cédula recibida: " . $cedula);
    echo "Cédula recibida: " . $cedula;
}

// Paso 1: Obtener los datos del empleado usando la cédula
$sql = "SELECT * FROM empleados WHERE cedula = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Error al preparar la consulta: " . $conn->error);
    echo "Error al preparar la consulta.";
    exit;
}
$stmt->bind_param("s", $cedula);
$stmt->execute();
$result = $stmt->get_result();
$empleado = $result->fetch_assoc();

// Verificar si el empleado existe
if ($empleado) {
    // Verificar y ajustar el estado del empleado antes de insertar
    if ($empleado['estado'] == '1') {
        $empleado['estado'] = '0';
    }

    // Paso 2: Insertar los datos del empleado en la tabla empleados_eliminados
    $sql_insert = "INSERT INTO e_eliminados (
        cedula, prefijo, tomo, asiento, nombre1, nombre2, apellido1, apellido2, apellidoc,
        genero, estado_civil, tipo_sangre, usa_ac, f_nacimiento, celular, telefono, correo, contraseña,
        provincia, distrito, corregimiento, calle, casa, comunidad, nacionalidad, f_contra, cargo,
        departamento, estado
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    if (!$stmt_insert) {
        error_log("Error al preparar la consulta de inserción: " . $conn->error);
        echo "Error al preparar la consulta de inserción.";
        exit;
    }
    $stmt_insert->bind_param(
        "sssssssssssssssssssssssssssss",
        $empleado['cedula'], $empleado['prefijo'], $empleado['tomo'], $empleado['asiento'], $empleado['nombre1'],
        $empleado['nombre2'], $empleado['apellido1'], $empleado['apellido2'], $empleado['apellidoc'], $empleado['genero'],
        $empleado['estado_civil'], $empleado['tipo_sangre'], $empleado['usa_ac'], $empleado['f_nacimiento'], $empleado['celular'],
        $empleado['telefono'], $empleado['correo'], $empleado['contraseña'], $empleado['provincia'], $empleado['distrito'],
        $empleado['corregimiento'], $empleado['calle'], $empleado['casa'], $empleado['comunidad'], $empleado['nacionalidad'],
        $empleado['f_contra'], $empleado['cargo'], $empleado['departamento'], $empleado['estado']
    );

    if ($stmt_insert->execute() === false) {
        error_log("Error al insertar en e_eliminados: " . $stmt_insert->error);
        echo "Error al mover el empleado a la tabla de eliminados.";
        exit;
    }

    // Paso 3: Actualizar el estado del empleado a "inactivo" en la tabla empleados
    $sql_update = "UPDATE empleados SET estado = 'inactivo' WHERE cedula = ?";
    $stmt_update = $conn->prepare($sql_update);
    if (!$stmt_update) {
        error_log("Error al preparar la consulta de actualización: " . $conn->error);
        echo "Error al preparar la consulta de actualización.";
        exit;
    }
    $stmt_update->bind_param("s", $cedula);

    if ($stmt_update->execute() === false) {
        error_log("Error al actualizar estado en empleados: " . $stmt_update->error);
        echo "Error al actualizar el estado del empleado.";
        exit;
    }

    // Paso 4: Eliminar físicamente al empleado de la tabla empleados
    $sql_delete = "DELETE FROM empleados WHERE cedula = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    if (!$stmt_delete) {
        error_log("Error al preparar la consulta de eliminación: " . $conn->error);
        echo "Error al preparar la consulta de eliminación.";
        exit;
    }
    $stmt_delete->bind_param("s", $cedula);

    if ($stmt_delete->execute() === false) {
        error_log("Error al eliminar de empleados: " . $stmt_delete->error);
        echo "Error al eliminar físicamente al empleado.";
        exit;
    }

    // Paso 4: Mover el usuario asociado a la tabla u_eliminados
    $sql_usuario = "SELECT * FROM usuarios WHERE cedula = ?";
    $stmt_usuario = $conn->prepare($sql_usuario);
    if (!$stmt_usuario) {
        error_log("Error al preparar la consulta de selección de usuario: " . $conn->error);
        echo "Error al preparar la consulta de selección de usuario.";
        exit;
    }
    $stmt_usuario->bind_param("s", $cedula);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();
    $usuario = $result_usuario->fetch_assoc();

    if ($usuario) {
        $sql_insert_usuario = "INSERT INTO u_eliminados (cedula, contraseña, correo_institucional) VALUES (?, ?, ?)";
        $stmt_insert_usuario = $conn->prepare($sql_insert_usuario);
        if (!$stmt_insert_usuario) {
            error_log("Error al preparar la consulta de inserción en u_eliminados: " . $conn->error);
            echo "Error al preparar la consulta de inserción en u_eliminados.";
            exit;
        }
        $stmt_insert_usuario->bind_param("sss", $usuario['cedula'], $usuario['contraseña'], $usuario['correo_institucional']);

        if ($stmt_insert_usuario->execute() === false) {
            error_log("Error al insertar en u_eliminados: " . $stmt_insert_usuario->error);
            echo "Error al mover el usuario a la tabla de usuarios eliminados.";
            exit;
        }

        // Paso 5: Eliminar físicamente al usuario de la tabla usuarios
        $sql_delete_usuario = "DELETE FROM usuarios WHERE cedula = ?";
        $stmt_delete_usuario = $conn->prepare($sql_delete_usuario);
        if (!$stmt_delete_usuario) {
            error_log("Error al preparar la consulta de eliminación de usuario: " . $conn->error);
            echo "Error al preparar la consulta de eliminación de usuario.";
            exit;
        }
        $stmt_delete_usuario->bind_param("s", $cedula);

        if ($stmt_delete_usuario->execute() === false) {
            error_log("Error al eliminar de usuarios: " . $stmt_delete_usuario->error);
            echo "Error al eliminar físicamente al usuario.";
            exit;
        }

        $stmt_insert_usuario->close();
        $stmt_delete_usuario->close();
    }

    $stmt_usuario->close();

    // Verificación de éxito
    if ($stmt_insert->affected_rows > 0 && $stmt_update->affected_rows > 0 && $stmt_delete->affected_rows > 0) {
        echo "Empleado marcado como inactivo, movido a la tabla de empleados eliminados y eliminado físicamente.";
    } else {
        echo "Error al realizar las operaciones sobre el empleado.";
    }

    $stmt_insert->close();
    $stmt_update->close();
    $stmt_delete->close();
} 

$stmt->close();
$conn->close();
?>
