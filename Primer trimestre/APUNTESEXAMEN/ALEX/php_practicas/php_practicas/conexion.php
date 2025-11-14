<?php
$conexion = new mysqli("localhost","root","","examen_php");

if($conexion -> connect_error){

    die("Error de conexion " . $conexion -> connect_error);

}

?>