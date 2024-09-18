<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE autores SET nombre = :nombre WHERE id = :id");
        $stmt->execute([
            ':id' => $_POST['id'],
            ':nombre' => $_POST['nombre']
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
    $stmt = $pdo->prepare("SELECT * FROM autores WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $autor = $stmt->fetch();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<h1>Editar Autor</h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $autor['id'] ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?= escape($autor['nombre']) ?>" required>
    <button type="submit">Actualizar</button>
</form>

<?php require_once '../includes/footer.php'; ?>