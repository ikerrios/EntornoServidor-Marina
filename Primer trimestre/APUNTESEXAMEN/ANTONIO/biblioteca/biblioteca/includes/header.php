<?php
// Recogemos la cookie 'tema'. Si no existe, usamos 'claro' como valor por defecto.
$tema = $_COOKIE['tema'] ?? 'claro';

?>
<!DOCTYPE html>
<!-- data-tema es un atributo personalizado para poder aplicar estilos diferentes
    según el tema elegido (claro/oscuro) desde CSS.-->
<html lang="es" data-tema="<?php echo $tema; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
</head>
<body>
    <div class="header">
        <div class="nav" style="display: flex; align-items: center; gap: 10px;">
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
            <a href="cerrar_sesion.php">Cerrar sesión</a>
            <a href="preferencias.php">Tema</a>
            
        </div>
    </div>
</body>
</html>
