<?php
/**
 * Carga variables de entorno desde un archivo .env
 * @param string $path Ruta al archivo .env
 */
function loadEnv($path) {
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

/**
 * Verifica si el usuario ha iniciado sesión
 * @return bool True si el usuario ha iniciado sesión, false en caso contrario
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Redirige a una nueva ubicación
 * @param string $location URL a la que redirigir
 */
function redirect($location) {
    header("Location: $location");
    exit;
}

/**
 * Establece un mensaje flash en la sesión
 * @param string $message Mensaje a mostrar
 * @param string $type Tipo de mensaje (info, success, error)
 */
function setFlashMessage($message, $type = 'info') {
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Obtiene y elimina el mensaje flash de la sesión
 * @return array|null Mensaje flash o null si no hay mensaje
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flashMessage = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flashMessage;
    }
    return null;
}

/**
 * Obtiene un usuario por su ID
 * @param int $id ID del usuario
 * @return array|null Datos del usuario o null si no se encuentra
 */
function getUserById($id) {
    $users = getUsers();
    return isset($users[$id]) ? $users[$id] : null;
}

/**
 * Obtiene un usuario por su email
 * @param string $email Email del usuario
 * @return array|null Datos del usuario o null si no se encuentra
 */
function getUserByEmail($email) {
    $users = getUsers();
    foreach ($users as $id => $user) {
        if ($user['email'] === $email) {
            return ['id' => $id] + $user;
        }
    }
    return null;
}