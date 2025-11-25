<?php
// index.php - Punto de entrada único

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config/database.php";
require_once "modelos/conexion.php";
require_once "modelos/animal.php";
require_once "modelos/perro.php";
require_once "modelos/gato.php";

require_once "controladores/AnimalController.php";
require_once "controladores/PerroController.php";
require_once "controladores/GatoController.php";

// Router muy simple
$controller = $_GET['c'] ?? 'animal';
$action     = $_GET['a'] ?? 'index';

$controller = ucfirst($controller) . 'Controller';

if (!class_exists($controller)) {
    die("Controlador no encontrado");
}

$ctrl = new $controller();

if (!method_exists($ctrl, $action)) {
    die("Acción no encontrada");
}

$ctrl->$action();