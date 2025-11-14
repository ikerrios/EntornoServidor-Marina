<?php
// Borrar cookie (caducidad pasada)
setcookie("usuario", "", time() - 3600, "/", "", false, true);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Borrar cookie</title></head>
<body>
<h2>Cookie eliminada</h2>
<p>La cookie <strong>usuario</strong> ha sido eliminada.</p>
<p><a href="leer_cookie.php">Comprobar cookie</a> | <a href="index.php">Volver</a></p>
</body></html>