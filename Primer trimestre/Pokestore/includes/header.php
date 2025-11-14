<?php
//Leo la cookie 'tema'; si no existe, por defecto 'claro'
$tema = $_COOKIE['tema'] ?? 'claro';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Pokestore</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<!-- Aplico la clase en el body según la cookie (claro/oscuro) -->
<body class="<?= htmlspecialchars($tema, ENT_QUOTES, 'UTF-8') ?>">
