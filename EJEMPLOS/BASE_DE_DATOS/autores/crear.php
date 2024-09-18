<?php
require_once '../includes/header.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO autores (nombre) VALUES (:nombre)");
        $stmt->execute([':nombre' => $_POST['nombre']]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<h1>Añadir Nuevo Autor</h1>
<form method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>
    <button type="submit">Guardar</button>
</form>

<?php require_once '../includes/footer.php'; ?>