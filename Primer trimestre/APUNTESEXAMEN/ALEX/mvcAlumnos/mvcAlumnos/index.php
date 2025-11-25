<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    session_start();
    
    require_once __DIR__ . '/controladores/AlumnoController.php';

    $controller = new AlumnoController();
    $controller->index();