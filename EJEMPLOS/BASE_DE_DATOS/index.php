<?php
require_once 'includes/header.php';
require_once 'config/database.php';

try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT COUNT(*) as libro_count FROM libros");
    $libroCount = $stmt->fetch()['libro_count'];

    $stmt = $pdo->query("SELECT COUNT(*) as autor_count FROM autores");
    $autorCount = $stmt->fetch()['autor_count'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<h1>Bienvenido a la Gestión de Biblioteca</h1>
<p>Este sistema te permite gestionar libros y autores de una biblioteca.</p>

<h2>Estadísticas</h2>
<ul>
    <li>Número total de libros: <?= $libroCount ?></li>
    <li>Número total de autores: <?= $autorCount ?></li>
</ul>

<h2>Acciones Rápidas</h2>
<ul>
    <li><a href="<?php echo getenv('BASE_URL'); ?>/libros/crear.php">Añadir un nuevo libro</a></li>
    <li><a href="<?php echo getenv('BASE_URL'); ?>/autores/crear.php">Añadir un nuevo autor</a></li>
    <li><a href="<?php echo getenv('BASE_URL'); ?>/procedimientos/libros_por_autor.php">Ver libros por autor</a></li>
</ul>

<?php require_once 'includes/footer.php'; ?>