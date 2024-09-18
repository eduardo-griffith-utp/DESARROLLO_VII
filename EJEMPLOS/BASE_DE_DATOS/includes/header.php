<?php 
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Biblioteca</title>
    <link rel="stylesheet" href="<?php echo getenv('BASE_URL'); ?>/public/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="<?php echo getenv('BASE_URL'); ?>/index.php">Inicio</a></li>
                <li><a href="<?php echo getenv('BASE_URL'); ?>/libros/index.php">Libros</a></li>
                <li><a href="<?php echo getenv('BASE_URL'); ?>/autores/index.php">Autores</a></li>
                <li><a href="<?php echo getenv('BASE_URL'); ?>/procedimientos/libros_por_autor.php">Libros por Autor</a></li>
            </ul>
        </nav>
    </header>
    <main>