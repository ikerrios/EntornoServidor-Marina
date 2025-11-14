<?php
session_start();

require_once 'includes/arrays.php';

if (!$_SESSION['usuario']) {
    header ('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado - Biblioteca</title>
</head>
<body>
    <h1>Listado - Biblioteca</h1>
    <p>Bienvenido, <strong><?php echo ($_SESSION['usuario']) ?></strong></p>

    <?php
        foreach ($libros as $libro => $info) { // Del array de libros, recorre posición por posición llamandolo libro al objeto e info será lo que compone a este. 
           
            echo "</br></br><b>" . $info['titulo'] . "</b></br>";
            echo $info['autor'] . "</br>";
            echo $info['año'] . "</br>";
            if ($info['disponible'] == true) { //Tras mostrar autor y año, si disponible es true que lo muestre.
                echo "Disponible";
            } else { // si no, recorre el array de usuarios y lo que tengas dentro se llamara infousuario.
                foreach($usuarios as $usuario => $infoUsuario) { // si el array de libros, el titulo es lo que contiene el libro prestado al usuario
                    if (in_array($info['titulo'], $infoUsuario['librosPrestados'])) {
                        echo "Prestado a: " . $infoUsuario['nombre']; // muestra a quien se lo ha prestado.
                    }
                }
            } 
        };echo "</br></br>";

        echo "<a href = 'prestamos.php'> Pedir Préstamo</a> ";
        echo "<a href = 'añadirUsuario.php'>Añadir Usuario</a> ";
        echo "<a href = 'añadirLibro.php'>Añadir Libro</a> ";
    ?>
</body>
</html>