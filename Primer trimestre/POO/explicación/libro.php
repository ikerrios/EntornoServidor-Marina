<?php
    class libro {
        //propiedades.

        private String $titulo;
        private String $autor;
        public float $precio;
        private int $stock;

        //métodos mágicos.
        public function __construct($titulo, $autor, $precio, $stock) {
            $this->titulo = $titulo;
            $this->autor = $autor;
            $this->precio = $precio;
            $this->stock = $stock;
        }

        //métodos.
        public function leer() {
            $info = $this->titulo . " " . $this->autor . " " . $this->precio . " " . $this->stock;

            return $info;
        }
    }

    $libro1 = new libro("Capitan calzoncillos", "Iker", 14.99, 4);
    echo $libro1->leer();

    //Se cambia el valor.
    $libro1->precio = 5.6;
    echo $libro1 -> leer();
?>