<?php   
    require_once("libro.php") ;
    
     class comic extends libro{
        //propiedades
        public string $volumen;

        //metodo nmagico
        public function __construct($titulo, $autor, $precio, $stock, $volumen){
           parent::__construct($titulo, $autor, $precio, $stock);
            $this->volumen = $volumen;
        }

        //metodo 
        public function leer(){
            $info = parent::leer() . " volumen: " . $this->volumen . ".";
            return $info;
        }
    }
        $comic1 = new comic(
            titulo: "El verano en que Hikaru Murió",
            autor: "Mokumokuren",
            precio: 8,
            stock: 100,
            volumen:"1"
        );
        



