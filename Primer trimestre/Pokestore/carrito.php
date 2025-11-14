<?php
session_start();

require_once 'includes/datos_cartas.php'; //Trae lo del archivo datos_cartas aqui.

$carrito = $_SESSION['carrito'] ?? []; //creo la variable de sesión carrito para almacenar el carro de la variable global
$precioTotal = 0;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') { //Si ha recibido algún POST.

    if (empty($_SESSION['carrito'])) //Si la variable de sessión de carrito no tiene nada, que diga que esta vacío.
        echo "El carrito esta vacío";
    else {
        unset($_SESSION['carrito']); //Si tiene contenido, eliminalo.
    }

    header('Location: carrito.php'); 
    exit;
}

echo '<h2>Carrito</h2>';
if (empty($carrito)) { //vacio
    echo 'El carrito está vacío';
} else {
    foreach ($carrito as $i => $nombre) { //si no esta vacío, lo que este en la posición i dame su nombre.
        echo ($i+1).'. '.htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') . ' ';
        echo $cartas[$nombre]['precio'] . '€' . "</br></br>"; // Muestrame del array de cartas, según el nombre, su precio.
        $precioTotal += $cartas[$nombre]['precio']; 
    }
  
}


if ($precioTotal != 0) {
    echo "Total de compra: " . $precioTotal . "€"; //Si el precio es diferente de 0, que no salga el total.
}

echo '<p><a href="catalogo.php">Volver al catálogo</a></p>';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body></br>

    <form method="post" action="">
        <button type="submit">VACIAR CARRITO</button>
        <input type="hidden" name="vaciar" value="<?= htmlspecialchars($vaciar, ENT_QUOTES, 'UTF-8') ?>">
    </form>
    
</body>
</html>