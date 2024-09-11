<?php
// Archivo para manejar el inicio de sesión de usuarios
require_once 'includes/header.php';

// Procesa el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $user = getUserByEmail($email);

    // Verifica las credenciales del usuario
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        setFlashMessage('Has iniciado sesión correctamente', 'success');
        redirect('dashboard.php');
    } else {
        setFlashMessage('Email o contraseña incorrectos', 'error');
    }
}
?>

<h2>Iniciar Sesión</h2>
<form method="post">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Iniciar Sesión</button>
</form>

<?php
require_once 'includes/footer.php';
?>