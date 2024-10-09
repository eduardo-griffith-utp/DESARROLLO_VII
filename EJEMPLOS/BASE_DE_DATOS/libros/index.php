<?php
require_once '../includes/header.php';
require_once '../config/database.php';

try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT libros.*, autores.nombre as autor_nombre FROM libros JOIN autores ON libros.autor_id = autores.id");
    
    $libros = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<h1>Libros</h1>
<a href="crear.php">Añadir nuevo libro</a>
<table>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($libros as $libro): ?>
    <tr>
        <td><?= escape($libro['id']) ?></td>
        <td><?= escape($libro['titulo']) ?></td>
        <td><?= escape($libro['autor_nombre']) ?></td>
        <td>
            <a href="editar.php?id=<?= $libro['id'] ?>">Editar</a>
            <a href="eliminar.php?id=<?= $libro['id'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once '../includes/footer.php'; ?>