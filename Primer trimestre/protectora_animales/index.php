<?php
require_once "modelo/animal.php";

if (isset($_POST['crear_animal'])) {
    $a = new Animal($_POST['nombre'], $_POST['edad'], $_POST['tipo']);
    $a->agregar();
}

if (isset($_POST['crear_perro'])) {
    $p = new Perro($_POST['nombre'], $_POST['edad'], $_POST['raza']);
    $p->agregar();
}

if (isset($_POST['crear_gato'])) {
    $g = new Gato($_POST['nombre'], $_POST['edad'], $_POST['color']);
    $g->agregar();
}

if (isset($_GET['eliminar'])) {
    Animal::eliminar($_GET['eliminar']);
}

$animales = Animal::listar();
$perros = Perro::listar();
$gatos = Gato::listar();
?>

<h2>CRUD Protectora</h2>

<h3>Crear Animal genérico</h3>
<form method="post">
    Nombre: <input name="nombre">
    Edad: <input name="edad">
    Tipo: <input name="tipo">
    <button name="crear_animal">Crear Animal</button>
</form>

<h3>Crear Perro</h3>
<form method="post">
    Nombre: <input name="nombre">
    Edad: <input name="edad">
    Raza: <input name="raza">
    <button name="crear_perro">Crear Perro</button>
</form>

<h3>Crear Gato</h3>
<form method="post">
    Nombre: <input name="nombre">
    Edad: <input name="edad">
    Color: <input name="color">
    <button name="crear_gato">Crear Gato</button>
</form>

<hr>

<h3>Todos los animales</h3>
<?php foreach ($animales as $a): ?>
<p>
    <?= $a['nombre'] ?> - <?= $a['edad'] ?> años - <?= $a['tipo'] ?> 
    <a href='?eliminar=<?= $a['id'] ?>'>Eliminar</a>
</p>
<?php endforeach; ?>

<h3>Perros</h3>
<?php foreach ($perros as $p): ?>
<p>
    <?= $p['nombre'] ?> - <?= $p['edad'] ?> años - <?= $p['tipo'] ?> - <?= $p['raza'] ?>
</p>
<?php endforeach; ?>

<h3>Gatos</h3>
<?php foreach ($gatos as $g): ?>
<p>
    <?= $g['nombre'] ?> - <?= $g['edad'] ?> años - <?= $g['tipo'] ?> - <?= $g['color'] ?>
</p>
<?php endforeach; ?>
