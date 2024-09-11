<?php
// Página de dashboard del usuario
require_once 'includes/header.php';

// Verifica si el usuario ha iniciado sesión
if (!isLoggedIn()) {
    setFlashMessage('Debes iniciar sesión para acceder al dashboard', 'error');
    redirect('login.php');
}

// Obtiene la información del usuario y sus preferencias
$user = getUserById($_SESSION['user_id']);
$preferences = getUserPreferences();
$userTheme = isset($preferences[$_SESSION['user_id']]) ? $preferences[$_SESSION['user_id']]['theme'] : 'light';
?>

<h2>Dashboard</h2>
<p>Bienvenido, <?php echo htmlspecialchars($user['name']); ?>!</p>

<h3>Tus Preferencias</h3>
<p>Tu tema preferido es: <?php echo htmlspecialchars($userTheme); ?></p>
<p><a href="preferences.php">Cambiar preferencias</a></p>

<?php
require_once 'includes/footer.php';
?>