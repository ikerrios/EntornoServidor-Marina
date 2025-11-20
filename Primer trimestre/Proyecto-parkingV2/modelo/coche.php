<?php

class Coche {
    // Propiedades privadas (encapsulamiento)
    protected $matricula;
    protected $modelo;
    protected $velocidad;

    // Constructor: se ejecuta al crear un objeto Usuario.
    // Recibe matricula, modelo y velocidad y los asigna al objeto.
    public function __construct($matricula, $modelo) {
        $this->matricula = $matricula;       // Asignamos matricula recibido
        $this->modelo = $modelo;         // Asignamos modelo recibido
        $this->velocidad = 0;   // Asignamos velocidad a 0 
    }

    // --- Getters ---
    // Métodos que permiten obtener el valor de una propiedad privada
    public function getMatricula() { 
        return $this->matricula; 
    }
    public function getModelo() { 
        return $this->modelo; 
    }
    public function getVelocidad() { 
        return $this->velocidad; 
    }

    // --- Setters ---
    // Métodos para modificar las propiedades privadas
    public function setMatricula($matricula) { 
        $this->matricula = $matricula; 
    }
    public function setModelo($modelo) { 
        $this->modelo = $modelo; 
    }
    public function setVelocidad($velocidad) { 
        $this->velocidad = $velocidad; 
    }
}

?>