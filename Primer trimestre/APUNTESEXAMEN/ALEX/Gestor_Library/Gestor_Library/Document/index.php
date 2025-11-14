<?php

include'logica.php';

$libros = [
    ["titulo" => "libro1", "autor" => "Alex2", "year" => 2025, "disponible" => true],
    ["titulo" => "libro2", "autor" => "Alex2", "year" => 2026, "disponible" => true],
    ["titulo" => "libro3", "autor" => "Alex2", "year" => 2026, "disponible" => true],
    ["titulo" => "libro4", "autor" => "Alex2", "year" => 2026, "disponible" => true]
];

$users = [
    ["nombre" => "Alex", "edad" => 20, "librosPrestados" => []],
    ["nombre" => "Alex2", "edad" => 25, "librosPrestados" => []]
];

// Ejemplo de uso de funciones:
addLibro($libros, "nuevo libro", "nuevo autor", 2027);
new_user($users, "nuevo alex", 18);

prestarLibro($libros,$users,"Alex","libro1");
prestarLibro($libros,$users,"Alex","libro2");
prestarLibro($libros, $users, "Alex", "libro3");
prestarLibro($libros, $users, "Alex", "libro4");


//devolverLibro($libros, $users,"libro3", "Alex1");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Listado de Usuarios</h1>
<table>
    <tr>
        <th>Nombre</th>
        <th>Edad</th>
        <th>Libros Prestados</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['nombre'] ?></td>
            <td><?= $user['edad'] ?></td>
            <td><?= !empty($user['librosPrestados']) ? implode(", ", $user['librosPrestados']) : "Ninguno" ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h1>Listado de Libros</h1>
<table>
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Año</th>
        <th>Disponible</th>
    </tr>
    <?php foreach ($libros as $libro): ?>
        <tr>
            <td><?= $libro['titulo'] ?></td>
            <td><?= $libro['autor'] ?></td>
            <td><?= $libro['year'] ?></td>
            <td><?= $libro['disponible'] ? "Disponible" : "Prestado" ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h1>Estadísticas</h1>
<ul>
    <li>Total de libros: <?= totalLibros($libros) ?></li>
    <li>Porcentaje de libros prestados: <?= round(porcentaje($libros), 2) ?>%</li>
    <li>Usuario con más libros prestados: <?= maxPrestados($users)?></li>
</ul>
</body>
</html>

<hr>
<h2>Pruebas</h2>

<?php

addLibro($libros, "prueba1", "autor_prueba", 2025);
addLibro($libros, "prueba2", "autor_prueba2", 2026);
echo "<p>He añadido nuevos libros prueba1 y prueba2</p>";


new_user($users, "prueba_edad", 16);
echo "<p>Para ver el error, de edad</p>";

prestarLibro($libros, $users, "prueba_edad", "prueba1");


prestarLibro($libros, $users, "Alex", "prueba1");
prestarLibro($libros, $users, "Alex", "prueba2");


echo "<h3>Estadisticas nuevas</h3>";
echo "<ul>";
echo "<li>Total de libros: " . totalLibros($libros) . "</li>";
echo "<li>Porcentaje de libros prestados: " . round(porcentaje($libros), 2) . "%</li>";
echo "<li>Usuario con más libros prestados: " . maxPrestados($users)."</li>";
echo "</ul>";
?>

