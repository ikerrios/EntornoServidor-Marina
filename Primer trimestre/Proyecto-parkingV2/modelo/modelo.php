<?php

require_once("coche.php");

class Parking {
    private $parking = [];
    private $db;
    
    // Constructor: se ejecuta al crear un objeto Usuario.
    // Recibe matricula, modelo y velocidad y los asigna al objeto.
    public function __construct() {
        // 1. Guardamos la conexión PDO en una propiedad
        $this->db = Conexion::conectar();

        // 2. Inicializamos el array interno
        $this->parking = [];
        
        // 3. Preparamos y ejecutamos la consulta para cargar coches de la BD
        $stmt = $this->db->prepare("SELECT matricula, modelo, velocidad FROM coches");
        $stmt->execute();

         // 4. Obtenemos todas las filas como array asociativo
        $cochesBD = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 5. Recorremos cada fila y creamos objetos Coche
        foreach ($cochesBD as $fila) {

            // Creamos el objeto Coche con la matrícula y el modelo
            $coche = new Coche($fila["matricula"], $fila["modelo"]);

            // Le ponemos la velocidad real de la BD
            $coche->setVelocidad($fila["velocidad"]);

            // Lo guardamos en el array interno del Parking
            $this->parking[$fila["matricula"]] = $coche;
        }
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
        //En coche vamos almacenar el resultado de buscarMatricula(), es decir, si es null o contiene algo, este método lo busca.
        $coche = $this->buscarCoche($matricula);

        if($coche === null) {
            return "Error";
        }
        
        // En matricula coche va a llamar a la matrícula de este para saberla y velocidad igual.
        $matricula = $coche->getMatricula();
        $velocidad = $coche->getVelocidad();

        //En datos vamos almacenar un string de la matrícula y la velocidad.
        $datos = $matricula . ": " . $velocidad . " km/h";
        //Devolvemos el string de datos.
        return $datos;
    }
}

?>