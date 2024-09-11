<?php
class ValidacionException extends Exception {}

function validarNombre($nombre) {
    $nombre = trim(htmlspecialchars($nombre));
    if (empty($nombre) || strlen($nombre) > 100) {
        throw new ValidacionException("El nombre es inválido");
    }
    return $nombre;
}

function validarEmail($email) {
    $email = trim(filter_var($email, FILTER_SANITIZE_EMAIL));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new ValidacionException("El email es inválido");
    }
    return $email;
}

function validarContrasena($contrasena) {
    if (strlen($contrasena) < 8) {
        throw new ValidacionException("La contraseña debe tener al menos 8 caracteres");
    }
    return $contrasena;
}
?>
