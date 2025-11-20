<?php
require_once "animal.php";

class Gato extends Animal {
    private $color;

    public function __construct($nombre, $edad, $color) {
        parent::__construct($nombre, $edad, "gato");
        $this->color = $color;
    }

    // --- Geters ---
    // Métodos que permiten obtener el valor de una propiedad privada.
    public function getColor(){
        return $this->color;
    }

    // --- Setters ---
    // Métodos para modificar las propiedades privadas.
    public function setColor($color) {
        $this->color = $color;
    }
}
?>