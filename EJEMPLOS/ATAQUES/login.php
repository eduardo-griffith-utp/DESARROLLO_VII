<?php include('db.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión (SQL Injection)</title>
</head>
<body>
    <h2>Inicio de Sesión</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Consulta SQL vulnerable a inyección
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "Bienvenido, $username!";
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
        exit();
    }
    ?>

    <form method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username"><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password"><br>

        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
