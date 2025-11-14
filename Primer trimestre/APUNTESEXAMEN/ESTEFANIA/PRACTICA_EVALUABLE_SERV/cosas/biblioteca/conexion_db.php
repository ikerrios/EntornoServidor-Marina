<?php
    $basededatos = "tapa";
    $usuario = "root";
    $servidor = "localhost";
    $password = "root";

$conexion = mysqli_connect($servidor, $usuario, $password) or die ("No se ha conectado a la base de datos");

$db = mysqli_select_db($conexion, $basededatos) or die ("No se ha conectado a biblioteca");

