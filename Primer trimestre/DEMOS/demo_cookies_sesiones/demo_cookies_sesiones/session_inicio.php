<?php
session_start();
// Guardar datos en la sesión
$_SESSION["nombre"] = "Marina";
$_SESSION["rol"] = "admin";
$_SESSION["contador"] = ($_SESSION["contador"] ?? 0) + 1;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Iniciar sesión</title></head>
<body>
<h2>Sesión iniciada</h2>
<p>Datos guardados en la sesión:</p>
<ul>
  <li>Nombre: <?= $_SESSION["nombre"] ?></li>
  <li>Rol: <?= $_SESSION["rol"] ?></li>
  <li>Contador de visitas a esta página: <?= $_SESSION["contador"] ?></li>
</ul>
<p><a href="session_leer.php">Leer sesión</a> | <a href="index.php">Volver</a></p>
</body></html>