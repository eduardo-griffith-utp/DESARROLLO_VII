<?php
// Archivo para manejar el registro de nuevos usuarios
require_once 'includes/header.php';

// Procesa el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $users = getUsers();
    $newId = count($users) + 1;
    $users[$newId] = [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ];

    saveUsers($users);
    setFlashMessage('Registro exitoso. Por favor, inicia sesión.', 'success');
    redirect('login.php');
}
?>

<h2>Registrarse</h2>
<form method="post">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Registrarse</button>
</form>

<?php
require_once 'includes/footer.php';
?>