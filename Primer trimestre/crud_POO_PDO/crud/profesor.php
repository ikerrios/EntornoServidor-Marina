<?php
    require_once("conexion.php");

    class profesor extends usuario {
        private $departamento;

        //Se va a construir con estas 4 variables.
        public function __construct($nombre, $email, $password, $departamento) {
            //Llamo a la clase padre, con los atributos de esta.
            parent::__construct($nombre, $email, $password);
            //El que le añado.
            $this -> departamento = $departamento;
        }

        //Llamo y me da el curso
        public function getDepartamento() { 
            return $this->departamento; 
        }

        //Llamo y puedo modificar el curso.
        public function setDepartamento($departamento) {
            $this->departamento = $departamento; 
        }

        //Método agregar.
        public function agregarProfesor() {
            // Obtenemos conexión PDO
            $pdo = Conexion::conectar();

            // Preparamos la sentencia SQL con parámetros nombrados (más seguro)
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, departamento) VALUES (:nombre, :email, :password, :departamento)");

            // Ejecutamos la consulta enviando los valores del objeto
            $stmt->execute([
                ':nombre' => $this->nombre,
                ':email' => $this->email,
                ':password' => $this->password,
                ':departamento' => $this->departamento
            ]);
        }

        //Método listar
        public static function listarProfesor() {
            // Conexión a la base de datos
            $pdo = Conexion::conectar();

            // Ejecutamos directamente la consulta porque no hay parámetros
            $stmt = $pdo->query("SELECT nombre, departamento FROM usuarios where departamento is not null");

            // Devolvemos todos los registros como array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // DELETE → Elimina un usuario por ID
        public static function eliminarProfesor($id) {
            $pdo = Conexion::conectar();

            // Consulta SQL preparada
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");

            // Ejecutamos enviando el ID
            $stmt->execute([':id' => $id]);
        }
    }
?>