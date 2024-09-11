<?php
    require_once 'config.php';
    require_once 'validaciones.php';

    // Verificar CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error de validación CSRF");
    }
    
    // Generar un nuevo token CSRF para la próxima solicitud
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    try {
        // Validar y sanitizar datos de entrada
        $nombre = validarNombre($_POST['nombre'] ?? '');
        $email = validarEmail($_POST['email'] ?? '');
        $contrasena = validarContrasena($_POST['contrasena'] ?? '');
        $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

        // Verificar que las contraseñas coincidan
        if ($contrasena !== $confirmar_contrasena) {
            throw new ValidacionException("Las contraseñas no coinciden");
        }

        // Hash de la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // En lugar de guardar en la base de datos, simplemente mostraremos los datos
        $_SESSION['usuario_registrado'] = [
            'nombre' => $nombre,
            'email' => $email
        ];

        // Redirigir a página de éxito
        header("Location: registro_exitoso.php");
        exit();

    } catch (ValidacionException $e) {
        $error = $e->getMessage();
    } catch (Exception $e) {
        $error = "Error inesperado: " . $e->getMessage();
    }

    // Si llegamos aquí, hubo un error
    $_SESSION['error'] = $error;
    header("Location: index.php");
    exit();
?>