<?php

$aprobado = 0;
$suspenso = 0;

$alumnos = [
    "Iker" => 7.8,
    "Andrea" => 5.5,
    "Piedra" => 8.2,
    "Rati" => 4.3,
    "Turbo" => 3.5,
];


foreach($alumnos as $nombre => $nota) {
    echo "$nombre tiene un $nota";

    if ($nota < 5) {
        echo " Tu nota es una putísima mierda";
        $suspenso++;
    }elseif($nota >=5 && $nota <=7) {
        echo " No esta mal";
        $aprobado++;
    } else {
        echo " Notaza tt.";
        $aprobado++;
    }
    
}

$total = array_sum($alumnos);
$media = $total /count($alumnos);

if($media >= 7) {
    echo "La media de clase es: " . round($media, 2);
    echo "La clase va fuerte, fuegoooo";
} else {
    echo "La media de clase es: " . round($media, 2);
    echo "Repasar zorras";
}


echo "Los aprobados son: $aprobado y los suspensos son: $suspenso. ";


?>