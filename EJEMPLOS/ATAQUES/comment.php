<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comentario (XSS)</title>
</head>
<body>
    <h2>Dejar un Comentario</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $comment = $_POST['comment'];

        // Muestra el comentario sin escape, lo que permite XSS
        echo "Comentario: " . $comment;
    }
    ?>

    <form method="POST">
        <label for="comment">Comentario:</label>
        <input type="text" name="comment" id="comment"><br>

        <input type="submit" value="Enviar Comentario">
    </form>
</body>
</html>
