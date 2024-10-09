<?php
// Configuración de la base de datos
$host = 'localhost';
$user = "utp";
$pass = "123456";
$db_name = "taller_seguridad";

// Conectar a la base de datos
$conn = new mysqli($host, $user, $pass, $db_name);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
