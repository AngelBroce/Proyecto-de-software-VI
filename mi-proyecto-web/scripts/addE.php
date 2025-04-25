<?php
header('Content-Type: application/json');

$host = "localhost";
$usuario = "admin";
$contrasena = "1234";
$basededatos = "ds6";

$conn = new mysqli($host, $usuario, $contrasena, $basededatos);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Conexión fallida: " . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolectar datos del formulario
    $prefijo = $_POST['prefijo'] ?? null;
    $tomo = $_POST['tomo'] ?? null;
    $asiento = $_POST['asiento'] ?? null;
    
    // Generar la cédula concatenando prefijo, tomo y asiento con guiones
    $cedula = $prefijo . '-' . $tomo . '-' . $asiento;

    $nombre1 = strtolower(trim($_POST['nombre1'] ?? ''));
    $nombre2 = $_POST['nombre2'] ?? null;
    $apellido1 = strtolower(trim($_POST['apellido1'] ?? ''));
    $apellido2 = $_POST['apellido2'] ?? null;
    $apellidoc = $_POST['apellido_casada'] ?? null;

    $genero = $_POST['genero'] ?? null;
    $estado_civil = $_POST['estado_civil'] ?? null;
    $tipo_sangre = $_POST['tipo_sangre'] ?? null;
    $usa_ac = $_POST['usa_ac'] ?? null;
    $f_nacimiento = $_POST['f_nacimiento'] ?? null;
    $celular = $_POST['celular'] ?? null;
    $telefono = $_POST['telefono'] ?? null;

    // Generar correo institucional automáticamente
    $correo = $nombre1 . "." . $apellido1 . "@tudominio.com";

    // Generar contraseña aleatoria de 10 caracteres
    function generar_contraseña($longitud = 10) {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*';
        return substr(str_shuffle($caracteres), 0, $longitud);
    }
    $contrasena = generar_contraseña();

    $provincia = $_POST['provincia'] ?? null;
    $distrito = $_POST['distrito'] ?? null;
    $corregimiento = $_POST['corregimiento'] ?? null;
    $calle = $_POST['calle'] ?? null;
    $casa = $_POST['casa'] ?? null;
    $comunidad = $_POST['comunidad'] ?? null;
    $nacionalidad = $_POST['nacionalidad'] ?? null;
    $f_contra = $_POST['f_contratacion'] ?? null;
    $cargo = $_POST['cargo'] ?? null;
    $departamento = $_POST['departamento'] ?? null;
    $estado = $_POST['estado'] ?? null;

    // Consulta para insertar en empleados
    $sql_empleado = "INSERT INTO empleados (
        cedula, prefijo, tomo, asiento, nombre1, nombre2, apellido1, apellido2, apellidoc,
        genero, estado_civil, tipo_sangre, usa_ac, f_nacimiento, celular, telefono, correo, contraseña,
        provincia, distrito, corregimiento, calle, casa, comunidad, nacionalidad, f_contra, cargo,
        departamento, estado
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt1 = $conn->prepare($sql_empleado);
    $stmt1->bind_param(
        "sssssssssssssssssssssssssssss",
        $cedula, $prefijo, $tomo, $asiento, $nombre1, $nombre2, $apellido1, $apellido2, $apellidoc,
        $genero, $estado_civil, $tipo_sangre, $usa_ac, $f_nacimiento, $celular, $telefono, $correo, $contrasena,
        $provincia, $distrito, $corregimiento, $calle, $casa, $comunidad, $nacionalidad, $f_contra, $cargo,
        $departamento, $estado
    );

    // Insertar en usuarios
    $sql_usuario = "INSERT INTO usuarios (cedula, contraseña, correo_institucional) VALUES (?, ?, ?)";
    $stmt2 = $conn->prepare($sql_usuario);
    $stmt2->bind_param("sss", $cedula, $contrasena, $correo);

    $success = false;
    $message = "";

    if ($stmt1->execute() && $stmt2->execute()) {
        $success = true;
        $message = "Empleado y usuario registrados correctamente.";
    } else {
        $message = "Error al registrar: " . $conn->error;
    }

    $stmt1->close();
    $stmt2->close();
    $conn->close();

    // Devolver respuesta en formato JSON
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'email' => $correo,
        'password' => $contrasena
    ]);
    exit;
}
?>
