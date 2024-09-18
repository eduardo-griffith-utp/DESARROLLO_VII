<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("DELETE FROM libros WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: index.php");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}