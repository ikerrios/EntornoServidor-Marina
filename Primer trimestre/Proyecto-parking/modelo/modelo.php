<?php

require_once("coche.php");

class Parking {
    private $parking = [];
    
    // Constructor: se ejecuta al crear un objeto Usuario.
    // Recibe matricula, modelo y velocidad y los asigna al objeto.
    public function __construct($matricula, $modelo) {
        $this -> parking = $parking;
    }

    public function crearCoche($matricula, $modelo) {
        // Creamos un nuevo objeto Usuario con los datos del formulario
        if($matricula === '' || $modelo === '') {
            echo ("La matrícula o modelo no debe estar vacía.");
            return null;
        }
        
        $coche = new Coche($matricula, $modelo);
        return $coche;
    }

    public function guardarCoche($coche) {
        // Sacamos la matrícula del objeto coche.
        $matricula = $coche->getMatricula();
        // Guardamos el coche en el array usando la matrícula como clave.
        $this->parking[$matricula] = $coche;
    }

    public function buscarCoche($matricula) {
        // Si en el array parking la matricula que le paso no se encuentra (empty = vacío) devuelve nulo.
        if (empty($this->parking[$matricula])) {
            return null;
        }
        // Si no ha devuelto nulo, quiere decir que la encuentra
        //En variable coche guardamos la matricula que recibe por el parametro.
        $coche = $this->parking[$matricula];
        return $coche;
    }

    public function cambiarVelocidad($matricula, $velocidad) {
        // En coche vamos almacenar el resultado de buscarCoche(), es decir, si es null o contiene algo, este método lo busca.
        $coche = $this->buscarCoche($matricula);

        if($coche === null) {
            return false;
        } else {
            // Si contiene, coche va a llamar a modificarVelocidad y le vamos a pasar el parametro de velocidad al cual queremos tener ahora.
            $coche->setVelocidad($velocidad);
            return true;
        }
    }
    
    public function consultarVelocidad($matricula) {
        // En coche vamos almacenar el resultado de buscarCoche(), es decir, si es null o contiene algo, este método lo busca.
        $coche = $this->buscarCoche($matricula);

        if($coche === null) {
            return null;
        }
        
        // Si contiene, coche llama al método, dameVelocidad y este lo muestra.
        return $coche->getVelocidad();
    }

    public function mostrarDatosCoche($matricula) {
        $coche = $this->buscarCoche($matricula);

        if($coche === null) {
            return "Error";
        }

        $matricula = $coche->getMatricula();
        $velocidad = $coche->getVelocidad();

        $datos = $matricula . ": " . $velocidad . " km/h";
        return $datos;
    }
}

?>