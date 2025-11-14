<?php
    require_once("conexion.php");

    class alumno extends usuario {
        
        private $curso;

        //Se va a construir con estas 4 variables.
        public function __construct($nombre, $email, $password, $curso) {
            //Llamo a la clase padre, con los atributos de esta.
            parent::__construct($nombre, $email, $password);
            //El que le añado.
            $this -> curso = $curso;
        }

        //Llamo y me da el curso
        public function getCurso() { 
            return $this->curso; 
        }

        //Llamo y puedo modificar el curso.
        public function setCurso($curso) {
            $this->curso = $curso; 
        }

        //Método agregar.
        public function agregarAlumno() {
            // Obtenemos conexión PDO
            $pdo = Conexion::conectar();

            // Preparamos la sentencia SQL con parámetros nombrados (más seguro)
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, curso) VALUES (:nombre, :email, :password, :curso)");

            // Ejecutamos la consulta enviando los valores del objeto
            $stmt->execute([
                ':nombre' => $this->nombre,
                ':email' => $this->email,
                ':password' => $this->password,
                ':curso' => $this->curso
            ]);
        }

        //Método listar
        public static function listarAlumno() {
            // Conexión a la base de datos
            $pdo = Conexion::conectar();

            // Ejecutamos directamente la consulta porque no hay parámetros
            $stmt = $pdo->query("SELECT nombre, curso FROM usuarios where curso is not null");

            // Devolvemos todos los registros como array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // DELETE → Elimina un usuario por ID
        public static function eliminarAlumno($id) {
            $pdo = Conexion::conectar();

            // Consulta SQL preparada
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");

            // Ejecutamos enviando el ID
            $stmt->execute([':id' => $id]);
        }
    }
?>