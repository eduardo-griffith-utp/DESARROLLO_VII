<?php
// Página para gestionar las preferencias del usuario
require_once 'includes/header.php';

// Verifica si el usuario ha iniciado sesión
if (!isLoggedIn()) {
    setFlashMessage('Debes iniciar sesión para acceder a las preferencias', 'error');
    redirect('login.php');
}

// Procesa el formulario de preferencias
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = filter_input(INPUT_POST, 'theme', FILTER_SANITIZE_STRING);
    
    $preferences = getUserPreferences();
    $preferences[$_SESSION['user_id']] = ['theme' => $theme];
    saveUserPreferences($preferences);

    setFlashMessage('Preferencias actualizadas correctamente', 'success');
    
    // Establece una cookie con el tema elegido
    setcookie('user_theme', $theme, time() + (86400 * 30), "/"); // Cookie válida por 30 días
    
    redirect('dashboard.php');
}

// Obtiene las preferencias actuales del usuario
$preferences = getUserPreferences();
$currentTheme = isset($preferences[$_SESSION['user_id']]) ? $preferences[$_SESSION['user_id']]['theme'] : 'light';
?>

<h2>Preferencias de Usuario</h2>
<form method="post">
    <div>
        <label for="theme">Tema:</label>
        <select id="theme" name="theme">
            <option value="light" <?php echo $currentTheme === 'light' ? 'selected' : ''; ?>>Claro</option>
            <option value="dark" <?php echo $currentTheme === 'dark' ? 'selected' : ''; ?>>Oscuro</option>
        </select>
    </div>
    <button type="submit">Guardar Preferencias</button>
</form>

<?php
require_once 'includes/footer.php';
?>