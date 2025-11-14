<?php

    require_once("libro.php");

    //propiedades.
    class comic extends libro {
        
        private string $volumen;

        //Métodos mágicos.
        public function __construct($titulo, $autor, $precio, $stock, $volumen) {
            
            parent::__construct($titulo, $autor, $precio, $stock, $volumen);

            $this->volumen = $volumen;
        }

        //Método.
        public function leer() {
            $info = parent::leer() . " " . $this->volumen;

            return $info;
        }
    }

    $comic1 = new comic("zipi y zape", "Marina", 50, 20, "1");
    
    echo $comic1 -> leer();
?>