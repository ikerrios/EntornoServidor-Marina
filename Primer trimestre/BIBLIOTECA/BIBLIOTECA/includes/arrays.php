<?php

if (!isset($_SESSION['libros'])) {
    $_SESSION['libros'] = [
        [
            "titulo" => "Cien años de soledad",
            "autor" => "Gabriel García Márquez",
            "año" => 1967,
            "disponible" => true // true = disponible, false = prestado
        ],

        [
            "titulo" => "1984",
            "autor" => "George Orwell",
            "año" => 1949,
            "disponible" => false
        ],

        [
            "titulo" => "Don Quijote de la Mancha",
            "autor" => "Miguel de Cervantes",
            "año" => 1605,
            "disponible" => true
        ]
        ];
}

if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [
        [
            "nombre" => "Samu",
            "edad" => 22,
            "librosPrestados" => ['1984'] 
        ],
        
        [
            "nombre" => "Iker",
            "edad" => 20,
            "librosPrestados" => [] // no tiene ningún libro
        ]
        ];
}

$libros = $_SESSION['libros'];
$usuarios = $_SESSION['usuarios'];