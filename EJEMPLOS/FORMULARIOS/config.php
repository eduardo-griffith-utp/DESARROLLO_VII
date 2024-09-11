<?php
    // Asegurarse de que la sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Generar CSRF token si no existe
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>