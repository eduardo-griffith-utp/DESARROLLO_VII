<?php
session_start();

if (!isset($_SESSION['usuario_registrado'])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION['usuario_registrado'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>¡Registro Exitoso!</h1>
        <p>Gracias por registrarte, <?php echo htmlspecialchars($usuario['nombre']); ?>.</p>
        <p>Tu email registrado es: <?php echo htmlspecialchars($usuario['email']); ?>.</p>
        <a href="index.php">Volver al inicio</a>
    </div>
</body>
</html>
<?php
// Limpiar la sesión después de mostrar los datos
unset($_SESSION['usuario_registrado']);
?>
