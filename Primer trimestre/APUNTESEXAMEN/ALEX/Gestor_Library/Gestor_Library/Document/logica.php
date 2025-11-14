<?php

/*
 * No sabia que para modificar el mismo array era necesario añadir
 * esto & al principio de los array como libros y users
 *
 * */
function addLibro(&$libros, $titulo, $autor, $year) {
    $libros[] = ["titulo" => $titulo, "autor" => $autor, "year" => $year, "disponible" => true];
}

function new_user(&$users, $nombre, $edad) {
    $users[] = ["nombre" => $nombre, "edad" => $edad, "librosPrestados" => []];
}


function prestarLibro (&$libros, &$users, $nombreUser, $nombreLibro){

    foreach ($users as &$user){

        if($user['nombre'] == $nombreUser){

            if($user['edad'] < 18){

                echo "<p> El usuario $nombreUser es menor de edad, necesita un padre para prestar</p>";

                return;
            }

            foreach ($libros as &$libro){
                if($libro['titulo'] == $nombreLibro){
                    if($libro['disponible']){
                        $libro['disponible'] = false;
                        $user['librosPrestados'][] = $nombreLibro;
                        echo "<p> $nombreUser Ha prestado el libro $nombreLibro. </p>";
                    }else{
                        echo "<p> $nombreLibro No esta disponible. </p>";
                    }
                    return;
                }
            }
            echo "<p> Ese libro no existe </p>";
        }
    }
    echo "<p> Ese usuario no existe </p>";
}

function devolverLibro(&$libros, &$users, $nombreLibro, $nombreUser){

    foreach ($users as &$user){
        if($user['nombre'] ==$nombreUser){
            if(($key = array_search($nombreLibro,$user['librosPrestados'])) !== false){
                unset($user['librosPrestados'][$key]);
                foreach ($libros as &$libro){
                    if ($libro['titulo'] == $nombreLibro){
                        $libro['disponible'] = true;
                        return true;
                    }
                }
            }
        }

    }
    return false;
}

function totalLibros($libros){
    return count($libros);
}

function porcentaje($libros){

    $prestados = 0;

    foreach ($libros as $libro){

        if(!$libro['disponible']) {

            $prestados++;
        }
    }
    return count($libros) > 0 ? ($prestados / count($libros)) * 100 : 0;
}

function maxPrestados($users){

    $num_maxPrestado = 0;
    $nombre_maxPrestado = '';

    foreach ($users as $user){

        if(count($user['librosPrestados']) > $num_maxPrestado){
            $num_maxPrestado = count($user['librosPrestados']);
            $nombre_maxPrestado = $user['nombre'];
        }
    }
    return $nombre_maxPrestado ?: null;

}
?>
