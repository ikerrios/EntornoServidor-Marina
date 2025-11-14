<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Leer sesión</title></head>
<body>
<h2>Leer datos de sesión</h2>
<?php
if (isset($_SESSION["nombre"])) {
  echo "<p>Bienvenida, <strong>" . htmlspecialchars($_SESSION["nombre"]) . "</strong>.</p>";
  echo "<p>Tu rol es: <strong>" . htmlspecialchars($_SESSION["rol"]) . "</strong></p>";
  echo "<p>Has visitado esta página " . $_SESSION["contador"] . " veces.</p>";
} else {
  echo "<p>No hay datos de sesión activos.</p>";
}
?>
<p><a href="index.php">Volver</a></p>
</body></html>