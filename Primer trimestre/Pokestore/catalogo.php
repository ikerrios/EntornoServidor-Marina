<?php
session_start();

require_once 'includes/datos_cartas.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Pokemon</title>
</head>
<body>
    <h1>Catálogo Pokemon</h1>
    <p>Bienvenido, <strong><?php echo ($_SESSION['usuario']) ?></strong></p>

    <?php
        foreach ($cartas as $carta => $info) {//Del array de CARTAS cojo cada nombre y lo hago otro array llamado CARTA y su información de dentro se llama info
           
            echo $carta . " - ";
            echo $info['tipo'] . "</br>";
            echo $info['precio'] . "</br>";
            echo "<a href = 'detalle.php?id=$carta'>detalles</a><br>";
            echo "</br>";
        };
    ?>

    <a href = "preferencias.php">Preferencias</a>
    <a href = "cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>