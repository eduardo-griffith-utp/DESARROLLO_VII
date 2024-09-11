<?php
// Inicia la sesión y carga las configuraciones necesarias
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Carga las variables de entorno
loadEnv(__DIR__ . '/../.env');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Autenticación</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="preferences.php">Preferencias</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="register.php">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        // Muestra mensajes flash si existen
        $flashMessage = getFlashMessage();
        if ($flashMessage): ?>
            <div class="flash-message <?php echo $flashMessage['type']; ?>">
                <?php echo $flashMessage['message']; ?>
            </div>
        <?php endif; ?>