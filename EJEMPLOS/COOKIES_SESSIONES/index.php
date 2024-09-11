<?php
require_once 'includes/header.php';
?>

<h1>Bienvenido al Sistema de Autenticación</h1>
<p>Este es un ejemplo de sistema que utiliza cookies y sesiones.</p>

<?php if (isLoggedIn()): ?>
    <p>Estás logueado. <a href="dashboard.php">Ir al Dashboard</a></p>
<?php else: ?>
    <p>Por favor, <a href="login.php">inicia sesión</a> o <a href="register.php">regístrate</a>.</p>
<?php endif; ?>

<?php
require_once 'includes/footer.php';
?>