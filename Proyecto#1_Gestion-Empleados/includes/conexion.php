<?php
// Configuración de la conexión
$host = "localhost"; // Cambia esto si tu servidor no es localhost
$user = "angel"; // Usuario de la base de datos
$password = "1234"; // Contraseña de la base de datos
$dbname = "ds6"; // Cambia esto por el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos.";
}

// Verificar si la conexión sigue activa
if ($conn->ping()) {
    echo "La conexión con la base de datos está activa.";
} else {
    echo "La conexión con la base de datos no está activa.";
}

// Cerrar la conexión (opcional aquí, pero recomendado en scripts más largos)
$conn->close();
?>