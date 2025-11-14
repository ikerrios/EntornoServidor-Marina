<?php
include 'conexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$result = $conexion->query("SELECT * FROM usuarios WHERE id = $id");

if ($result->num_rows === 0) {
    echo "Usuario no encontrado";
    exit;
}

$user = $result->fetch_assoc();

include 'form.php';
?>