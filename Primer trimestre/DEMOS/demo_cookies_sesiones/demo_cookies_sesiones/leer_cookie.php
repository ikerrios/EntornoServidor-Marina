<?php
// Leer cookie si existe
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Leer cookie</title></head>
<body>
<h2>Leer cookie</h2>
<?php
if (isset($_COOKIE["usuario"])) {
    echo "<p>Cookie 'usuario' encontrada. Valor: <strong>" . htmlspecialchars($_COOKIE["usuario"]) . "</strong></p>";
} else {
    echo "<p>No existe la cookie 'usuario'.</p>";
}
?>
<p><a href="index.php">Volver</a></p>
</body></html>