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
        echo "<h2>Usuarios y sus libros prestados</h2>";
        echo "<ul>";
        foreach($usuarios as $usuario => $infoUsuario) {
            echo "<li><strong>" . $infoUsuario['nombre'] . "</strong> (" . $infoUsuario['edad'] . " años): ";
            
            if (empty($infoUsuario['librosPrestados'])) {
                echo "no tiene libros prestados.";
            } else {
                echo "libros prestados: " . implode(", ", $infoUsuario['librosPrestados']);
            }
            
            echo "</li>";
        }
        echo "</ul>";

        // Funciones para estadísticas
        function numeroTotalLibros($libros) {
            return count($libros);
        }

        function porcentajeLibrosPrestados($libros) {
            $total = count($libros);
            if ($total == 0) {
                return 0;
            }
            $prestados = 0;
            foreach($libros as $libro) {
                if ($libro['disponible'] === false) {
                    $prestados++;
                }
            }
            return ($prestados / $total) * 100;
        }

        function usuarioConMasPrestamos($usuarios) {
            $max = -1;
            $nombre = null;

            foreach($usuarios as $infoUsuario) {
                $numPrestamos = count($infoUsuario['librosPrestados']);
                if ($numPrestamos > $max) {
                    $max = $numPrestamos;
                    $nombre = $infoUsuario['nombre'];
                }
            }

            return [
                'nombre' => $nombre,
                'total' => $max
            ];
        }

        $totalLibros = numeroTotalLibros($libros);
        $porcentajePrestados = porcentajeLibrosPrestados($libros);
        $usuarioTop = usuarioConMasPrestamos($usuarios);

        echo "<h2>Estadísticas</h2>";
        echo "<p>Número total de libros: <strong>" . $totalLibros . "</strong></p>";
        echo "<p>Porcentaje de libros prestados: <strong>" . number_format($porcentajePrestados, 2) . "%</strong></p>";
        if ($usuarioTop['nombre'] === null || $usuarioTop['total'] < 1) {
            echo "<p>Usuario con más libros en préstamo: <strong>Ninguno (no hay préstamos)</strong></p>";
        } else {
            echo "<p>Usuario con más libros en préstamo: <strong>" . $usuarioTop['nombre'] . " (" . $usuarioTop['total'] . " libros)</strong></p>";
        }

    ?>
</body>
</html>