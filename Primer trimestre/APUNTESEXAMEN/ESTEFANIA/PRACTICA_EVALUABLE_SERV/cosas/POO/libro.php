<?PHP
    class libro{
        //propiedades
        public $titulo;
        public $autor;
        public $precio;
        public $stock;

        //metodos
        public function leer(){
            $info = $this->titulo .  " de " . $this->autor . ", por el precio de " . $this->precio . " euros.";

            return $info;
        
        }
        //metodos magicos
        public function __construct($titulo, $autor, $precio, $stock) {
            $this->titulo = $titulo;
            $this->autor = $autor;
            $this->precio = $precio;
            $this->stock = $stock;
        }
    
    }


        $libro1 = new libro(
            titulo: "Alas de Sangre",
            autor: "Rebecca Yarros",
            precio: 23,
            stock: 100

        );


   ?>

   