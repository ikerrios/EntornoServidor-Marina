<?php
$nombre = urlencode("Tom & Jerry");
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>urlencode()</title></head>
<body>
<h2>Ejemplo de urlencode()</h2>
<p>El nombre codificado es: <code><?php echo $nombre; ?></code></p>
<a href="dibujos.php?preferido=<?php echo $nombre; ?>">Ver favorito</a>
<p><a href="index.php">Volver</a></p>
</body></html>