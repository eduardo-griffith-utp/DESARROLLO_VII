<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO libros (titulo, autor_id) VALUES (:titulo, :autor_id)");
        $stmt->execute([
            ':titulo' => $_POST['titulo'],
            ':autor_id' => $_POST['autor_id']
        ]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$stmt = $pdo->query("SELECT id, nombre FROM autores");
$autores = $stmt->fetchAll();
?>

<h1>Añadir Nuevo Libro</h1>
<form method="post">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" required>
    
    <label for="autor_id">Autor:</label>
    <select name="autor_id" required>
        <?php foreach ($autores as $autor): ?>
            <option value="<?= $autor['id'] ?>"><?= escape($autor['nombre']) ?></option>
        <?php endforeach; ?>
    </select>
    
    <button type="submit">Guardar</button>
</form>

<?php require_once '../includes/footer.php'; ?>