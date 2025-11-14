<?php
require_once('conexion_db.php');

$id = $_GET['id'];
$imagen = $_GET['imagen'];

$borrar = "DELETE FROM libro WHERE id = ".$id;
$ruta_imagen = "imagenes/" . basename($imagen);

if (!empty($imagen) && file_exists($ruta_imagen)) {
    unlink($ruta_imagen);
}

    if(mysqli_query($conexion, $borrar)) {
        header("location: listado.php");
        exit;
    }else {
        mysqli_error($conexion);
    }
?>

