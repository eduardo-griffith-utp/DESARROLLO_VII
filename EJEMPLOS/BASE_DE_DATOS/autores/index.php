<?php
require_once '../includes/header.php';
require_once '../config/database.php';

try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM autores");
    $autores = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<h1>Autores</h1>
<a href="crear.php">Añadir nuevo autor</a>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($autores as $autor): ?>
    <tr>
        <td><?= escape($autor['id']) ?></td>
        <td><?= escape($autor['nombre']) ?></td>
        <td>
            <a href="editar.php?id=<?= $autor['id'] ?>">Editar</a>
            <a href="eliminar.php?id=<?= $autor['id'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once '../includes/footer.php'; ?>