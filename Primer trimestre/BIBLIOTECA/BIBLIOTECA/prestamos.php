<?php
session_start();

require_once 'includes/arrays.php';

$mensaje = "";

// Procesar formulario de préstamos / devoluciones
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $accion = $_POST['accion'] ?? '';
    $indiceUsuario = isset($_POST['usuario']) ? (int) $_POST['usuario'] : -1;
    $indiceLibro = isset($_POST['libro']) ? (int) $_POST['libro'] : -1;

    if (!isset($usuarios[$indiceUsuario]) || !isset($libros[$indiceLibro])) {
        $mensaje = "Usuario o libro no válidos.";
    } else {
        // Referencias para modificar directamente
        $usuario =& $usuarios[$indiceUsuario];
        $libro   =& $libros[$indiceLibro];

        if ($accion === 'prestar') {

            if ($libro['disponible'] === false) {
                $mensaje = "Ese libro ya está prestado.";
            } elseif (in_array($libro['titulo'], $usuario['librosPrestados'])) {
                $mensaje = "Ese usuario ya tiene ese libro en préstamo.";
            } else {
                // Prestar: marcar no disponible y añadir al array del usuario
                $libro['disponible'] = false;
                $usuario['librosPrestados'][] = $libro['titulo'];
                $mensaje = "Préstamo realizado correctamente.";
            }

        } elseif ($accion === 'devolver') {

            if ($libro['disponible'] === true) {
                $mensaje = "Ese libro ya estaba disponible.";
            } else {
                $pos = array_search($libro['titulo'], $usuario['librosPrestados']);
                if ($pos === false) {
                    $mensaje = "Ese usuario no tiene ese libro en préstamo.";
                } else {
                    // Devolver: marcar disponible y quitar del array del usuario
                    unset($usuario['librosPrestados'][$pos]);
                    $usuario['librosPrestados'] = array_values($usuario['librosPrestados']); // reindexar
                    $libro['disponible'] = true;
                    $mensaje = "Libro devuelto correctamente.";
                }
            }
        }
    }

    // Guardar cambios en la sesión
    $_SESSION['libros'] = $libros;
    $_SESSION['usuarios'] = $usuarios;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos</title>
</head>
<body>
    <h1>Gestión de préstamos</h1>

    <?php if (!empty($mensaje)) : ?>
        <p><strong><?php echo htmlspecialchars($mensaje); ?></strong></p>
    <?php endif; ?>

    <h2>Realizar préstamo</h2>
    <form method="post" action="">
        <input type="hidden" name="accion" value="prestar">

        <label for="usuario_prestamo">Usuario:</label>
        <select name="usuario" id="usuario_prestamo">
            <?php foreach($usuarios as $indice => $infoUsuario): ?>
                <option value="<?php echo $indice; ?>">
                    <?php echo htmlspecialchars($infoUsuario['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="libro_prestamo">Libro:</label>
        <select name="libro" id="libro_prestamo">
            <?php foreach($libros as $indice => $infoLibro): ?>
                <?php if ($infoLibro['disponible'] === true): ?>
                    <option value="<?php echo $indice; ?>">
                        <?php echo htmlspecialchars($infoLibro['titulo']); ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <button type="submit">Prestar libro</button>
    </form>

    <h2>Devolver libro</h2>
    <form method="post" action="">
        <input type="hidden" name="accion" value="devolver">

        <label for="usuario_devolucion">Usuario:</label>
        <select name="usuario" id="usuario_devolucion">
            <?php foreach($usuarios as $indice => $infoUsuario): ?>
                <option value="<?php echo $indice; ?>">
                    <?php echo htmlspecialchars($infoUsuario['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="libro_devolucion">Libro:</label>
        <select name="libro" id="libro_devolucion">
            <?php foreach($libros as $indice => $infoLibro): ?>
                <option value="<?php echo $indice; ?>">
                    <?php echo htmlspecialchars($infoLibro['titulo']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Devolver libro</button>
    </form>

    <p><a href="listado.php">Volver al listado</a></p>
</body>
</html>
