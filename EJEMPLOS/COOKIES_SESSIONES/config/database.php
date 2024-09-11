<?php
// Este archivo simula operaciones de base de datos usando archivos PHP

/**
 * Obtiene la lista de usuarios desde un archivo
 * @return array Lista de usuarios
 */
function getUsers() {
    $usersFile = __DIR__ . '/../data/users.php';
    if (file_exists($usersFile)) {
        return include $usersFile;
    }
    return [];
}

/**
 * Guarda la lista de usuarios en un archivo
 * @param array $users Lista de usuarios a guardar
 */
function saveUsers($users) {
    $usersFile = __DIR__ . '/../data/users.php';
    file_put_contents($usersFile, '<?php return ' . var_export($users, true) . ';');
}

/**
 * Obtiene las preferencias de usuarios desde un archivo
 * @return array Preferencias de usuarios
 */
function getUserPreferences() {
    $preferencesFile = __DIR__ . '/../data/preferences.php';
    if (file_exists($preferencesFile)) {
        return include $preferencesFile;
    }
    return [];
}

/**
 * Guarda las preferencias de usuarios en un archivo
 * @param array $preferences Preferencias de usuarios a guardar
 */
function saveUserPreferences($preferences) {
    $preferencesFile = __DIR__ . '/../data/preferences.php';
    file_put_contents($preferencesFile, '<?php return ' . var_export($preferences, true) . ';');
}