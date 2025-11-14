<?php
// Crear cookie que dura 1 hora
setcookie("usuario", "Carlos", time() + 3600, "/", "", false, true); // httponly = true
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Crear cookie</title></head>
<body>
<h2>Cookie creada</h2>
<p>Se ha creado una cookie llamada <strong>usuario</strong> con valor <strong>Carlos</strong> que durará 1 hora.</p>
<p><em>Recuerda:</em> la cookie estará disponible en la próxima carga de página.</p>
<a href="leer_cookie.php">Leer cookie</a> | <a href="index.php">Volver</a>
</body></html>