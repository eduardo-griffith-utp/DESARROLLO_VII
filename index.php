<?php
  $nombre = "Eduardo";
  $edad = "56";
?>

<html>
  <head>
    <title>Hello HTML</title>
  </head>
  <body>
    <h1><?php echo "Bienvenido, $nombre!"; ?></h1>
    <p>Tu edad es: <?= $edad; ?></p>  
  </body>
</html>