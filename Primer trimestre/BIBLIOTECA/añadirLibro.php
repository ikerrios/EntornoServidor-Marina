<?php
session_start();

require_once 'includes/arrays.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $titulo = trim($_POST['Titulo']);
        $autor = trim($_POST['Autor']);
        $año = trim($_POST['Año']);
        $disponibilidad = trim($_POST['Disponibilidad']);

        if ($disponibilidad === "Disponible") {
            $disponibilidad = true;
        } elseif($disponibilidad === "Prestado") {
            $disponibilidad = false;
        }
    
        if(empty($titulo) || empty($autor) || empty($año) || $_POST['Disponibilidad'] === '') {
            echo "Algún campo esta vacío, por favor revísalo.";
        } else {

            $_SESSION['libros'][] = [
                "titulo" => $titulo,
                "autor" => $autor,
                "año" => $año,
                "disponible" => $disponibilidad
            ];

            if ($disponible === false) {
                if ($usuarios['edad'] < 18) {
                    echo "No puedes tomar un libro (menor de edad).";
                    exit;
                }       
                
                if (count($usuarios['librosPrestados']) >= 3) {
                    echo "No puedes tomar más libros (límite 3).";
                    exit;
                }
}

            header ('Location: listado.php');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Libro</title>
</head>
<body>
    <h2>Añadir Libro</h2>

    <form method="post" action="">
    <label for="Titulo">Titulo:</label>
    <input type="text" id="Titulo" name="Titulo"><br><br>

    <label for="Autor">Autor:</label>
    <input type="text" id="Autor" name="Autor"><br><br>
    
    <label for="Año">Año:</label>
    <input type="number" id="Año" name="Año"><br><br>

    <label for="Disponible">Disponibilidad:</label>
    <select id="Disponibilidad" name="Disponibilidad"><br><br>
        <option value="">--Selecciona--</option>
        <option value="Disponible">Disponible</option>
        <option value="Prestado">Prestado</option>
    </select></br></br>
 
    <button type="submit">Añadir</button>
</body>
</html>