<?php
//inicio de sesion 
session_start();

//cerrar la sesion
session_destroy();

// Redirigimos a login.php enviando una variable GET llamada 'mensaje' con el valor 'adios'.
// De esta forma, en login.php podremos mostrar un mensaje al usuario.
header('location: login.php?mensaje=adios');