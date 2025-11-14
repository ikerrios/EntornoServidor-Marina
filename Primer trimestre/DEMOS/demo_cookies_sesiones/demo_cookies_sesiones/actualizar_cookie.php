<?php
// Actualizar cookie
setcookie("usuario", "Lucía", time() + 3600, "/", "", false, true);
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Actualizar cookie</title></head>
<body>
<h2>Cookie actualizada</h2>
<p>La cookie <strong>usuario</strong> ahora tiene el valor <strong>Lucía</strong>.</p>
<p><a href="leer_cookie.php">Comprobar cookie</a> | <a href="index.php">Volver</a></p>
</body></html>