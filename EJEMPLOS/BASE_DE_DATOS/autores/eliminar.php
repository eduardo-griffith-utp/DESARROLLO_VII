<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

try {
    $pdo = getDBConnection();
    
    // Primero, eliminamos los libros asociados al autor
    $stmt = $pdo->prepare("DELETE FROM libros WHERE autor_id = :id");
    $stmt->execute([':id' => $id]);
    
    // Luego, eliminamos el autor
    $stmt = $pdo->prepare("DELETE FROM autores WHERE id = :id");
    $stmt->execute([':id' => $id]);
    
    header("Location: index.php");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}