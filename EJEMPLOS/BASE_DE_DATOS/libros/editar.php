<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE libros SET titulo = :titulo, autor_id = :autor_id WHERE id = :id");
        $stmt->execute([
            ':id' => $_POST['id'],
            ':titulo' => $_POST['titulo'],
            ':autor_id' => $_POST['autor_id']
        ]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM libros WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $libro = $stmt->fetch();

    $stmt = $pdo->query("SELECT id, nombre FROM autores");
    $autores = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<h1>Editar Libro</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $libro['id'] ?>">
    
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" value="<?= escape($libro['titulo']) ?>" required>
    
    <label for="autor_id">Autor:</label>
    <select name="autor_id" required>
        <?php foreach ($autores as $autor): ?>
            <option value="<?= $autor['id'] ?>" <?= $autor['id'] == $libro['autor_id'] ? 'selected' : '' ?>>
                <?= escape($autor['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <button type="submit">Actualizar</button>
</form>

<?php require_once '../includes/footer.php'; ?>