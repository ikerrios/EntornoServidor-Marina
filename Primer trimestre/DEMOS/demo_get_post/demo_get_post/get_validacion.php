<?php
// Validar si llega el parámetro 'q'
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Validación GET</title></head>
<body>
<h2>Validación de parámetro GET</h2>
<?php
if (isset($_GET["q"])) {
  echo "Has buscado: <strong>" . htmlspecialchars($_GET["q"]) . "</strong>";
} else {
  echo "No se ha enviado ninguna búsqueda.";
}
?>
<p><a href="?q=php">Probar con ?q=php</a></p>
<p><a href="index.php">Volver</a></p>
</body></html>