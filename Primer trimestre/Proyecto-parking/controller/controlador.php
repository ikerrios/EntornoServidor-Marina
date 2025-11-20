<?php
//Incluimos el archivo modelo.php
require_once("../modelo/modelo.php");

//Creamos el objeto de parking.
$parking = new Parking();

//Creamos los coches.
$coche1 = $parking->crearCoche("1111AAAA", "BMW");
$parking->guardarCoche($coche1);

$coche2 = $parking->crearCoche("2222BBBB", "AUDI");
$parking->guardarCoche($coche2);

$coche3 = $parking->crearCoche("3333CCCC", "SEAT");
$parking->guardarCoche($coche3);

//Cambiamos velocidad a uno de ellos.
$parking->cambiarVelocidad("1111AAAA", 80);

//Pedir el texto del coche.
$datos = $parking->mostrarDatosCoche("1111AAAA");

// Vista recibirá datos y los mostrará.
include "../vista/vista.php";
?>