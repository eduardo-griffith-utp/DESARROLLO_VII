<?php
require_once '../includes/header.php';
require_once '../config/database.php';

$pdo = getDBConnection();

// Crear el procedimiento almacenado si no existe
try {
    $pdo->exec("
    CREATE PROCEDURE IF NOT EXISTS GetLibrosPorAutor(IN autor_id INT)
    BEGIN
        SELECT libros.* FROM libros WHERE libros.autor_id = autor_id;
    END
    ");
} catch (PDOException $e) {
    echo "Error creando el procedimiento almacenado: " . $e->getMessage();
}

// Obtener la lista de autores
try {
    $stmt = $pdo->query("SELECT id, nombre FROM autores");
    $autores = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Procesar la selección del autor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['autor_id'])) {
    try {
        $stmt = $pdo->prepare("CALL GetLibrosPorAutor(:autor_id)");
        $stmt->execute([':autor_id' => $_POST['autor_id']]);
        $libros = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<h1>Libros por Autor</h1>
<form method="post">
    <label for="autor_id">Seleccionar Autor:</label>
    <select name="autor_id" required>
        <?php foreach ($autores as $autor): ?>
            <option value="<?= $autor['id'] ?>"><?= escape($autor['nombre']) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Buscar Libros</button>
</form>

<?php if (isset($libros)): ?>
    <h2>Libros del Autor Seleccionado</h2>
    <?php if (empty($libros)): ?>
        <p>No se encontraron libros para este autor.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($libros as $libro): ?>
                <li><?= escape($libro['titulo']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>