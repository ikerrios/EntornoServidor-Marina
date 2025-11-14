<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Destruir sesión</title></head>
<body>
<h2>Sesión destruida</h2>
<p>Todos los datos de sesión han sido eliminados.</p>
<p><a href="index.php">Volver al inicio</a></p>
</body></html>