<?php
session_start();
$id = session_id();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>ID de sesión</title></head>
<body>
<h2>ID de Sesión</h2>
<p>El identificador único de tu sesión actual es:</p>
<pre><?= $id ?></pre>
<p><a href="session_leer.php">Ver datos</a> | <a href="index.php">Volver</a></p>
</body></html>