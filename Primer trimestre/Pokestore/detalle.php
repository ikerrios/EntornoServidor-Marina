<?php
session_start();

require_once 'includes/datos_cartas.php'; //Trae lo del archivo datos_cartas aqui.


if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') { //Si ha recibido algún POST.

    $idPost = trim($_POST['id'] ?? ''); //almaceno el darle a ir al carrito en idPost, que es el name del formulario que es POST.
    
    if($idPost === '' || !isset($cartas[$idPost])) { //Si este esta vacio o la carta no se encuentra en el arraylist de cartas.
        $error = 'Carta inválida.';
        header ('Location: catalogo.php');
        exit;
    }
     

    if(!isset($_SESSION['carrito'])) { //Si no existe carrito.
        $_SESSION['carrito'] = []; //Creamos carrito
    }

    $_SESSION['carrito'][] = $idPost; //En el array de la variable de sesión carrito añadimos el id recibido.

    header('Location: carrito.php'); 
    exit;
}


if(!isset($_GET['id'])) { //Llego el id? 
    header ('Location: catalogo.php');
    echo ("No se ha encontrado el id.");
} else {
    $id = trim($_GET['id']); //Si ha llegado almacena en la variable $id el id que ha llegado.
}

if (!isset($cartas[$id])) { //¿Existe en el array de Cartas el ID que nos ha llegado?
    echo "No se ha encontrado este id";
    header ('Location: catalogo.php');
} else {
    foreach($cartas as $carta => $info) { //Hacemos un foreach para recorrer el arrayList de cartas y sus id le llamaremos por $carta y lo que tengamos dentro de carta sera $info.
        if($carta == $id) { //Si carta es igual al id que hemos recibido por la url almacenado en GET, imprime la información de la carta. 
            echo $carta . "</br>";
            echo $info['tipo'] . "</br>";
            echo $info['precio'] . "</br>";
            echo $info['descripcion'] . "</br>";
        }
    };
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles</title>
</head>
<body></br>

    <form method="post" action="">
        <button type="submit">AÑADIR AL CARRITO</button>
        <input type="hidden" name="id" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
    </form>

</body>
</html>