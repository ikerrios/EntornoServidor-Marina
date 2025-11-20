<?php
require_once "animal.php";

class Perro extends Animal {
    private $raza;

    public function __construct($nombre, $edad, $raza) {
        parent::__construct($nombre, $edad, "perro");
        $this->raza = $raza;
    }

    // --- Geters ---
    // Métodos que permiten obtener el valor de una propiedad privada.
    public function getRaza(){
        return $this->raza;
    }

    // --- Setters ---
    // Métodos para modificar las propiedades privadas.
    public function setRaza($raza) {
        $this->raza = $raza;
    }
}
?>