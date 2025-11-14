<?php

$inventario = [
    ["nombre" => "Poké Ball", "precio" => 50, "stock" => 20, "categoria" => "capturar"],
    ["nombre" => "Poción", "precio" => 20, "stock" => 10, "categoria" => "curacion"],
    ["nombre" => "Super Ball", "precio" => 150, "stock" => 15, "categoria" => "capturar"],
    ["nombre" => "Antídoto", "precio" => 30, "stock" => 25, "categoria" => "curacion"],
    ["nombre" => "Revivir", "precio" => 300, "stock" => 5, "categoria" => "curacion"]
];

function total_productos($inventario) {
    
    $total_productos = 0;

    foreach($inventario as $producto) {
        $total_productos = count($inventario); 
    }

    return $total_productos;

    echo "Hay un total de: $total_productos productos.";
}


function stock_total($inventario) {
   
   $stock_total = 0;

    foreach($inventario as $producto) {
        $stock_total += $producto["stock"];
    }

    return $stock_total;
}


function producto_mas_caro($inventario) {
    
    $producto_caro_ganador = 0;
    $producto_mas_caro = 0;

    foreach($inventario as $producto) {
        

        if($producto_mas_caro > $producto_caro_ganador) {
            $producto_mas_caro = $producto_caro_ganador;
        } else {
            $producto_caro_ganador = $producto["precio"];
        }

        return $producto_mas_caro;
 
    }

    echo "El producto mas caro es: ";
}



?>