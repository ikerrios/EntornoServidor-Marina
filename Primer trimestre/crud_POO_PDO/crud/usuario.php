<?php
// Incluimos el archivo de conexión para poder usar la clase Conexion
require_once("conexion.php");

class Usuario {

    // Propiedades privadas (encapsulamiento)
    protected $id;
    protected $nombre;
    protected $email;
    protected $password;

    // Constructor: se ejecuta al crear un objeto Usuario
    // Recibe nombre, email y password, y los asigna al objeto
    public function __construct($nombre = null, $email = null, $password = null) {
        $this->id = null;              // El ID será asignado por la BD, por eso lo dejamos en null
        $this->nombre = $nombre;       // Asignamos nombre recibido
        $this->email = $email;         // Asignamos email recibido
        $this->password = $password;   // Asignamos contraseña recibida
    }

    // --- Getters ---
    // Métodos que permiten obtener el valor de una propiedad privada
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }

    // --- Setters ---
    // Métodos para modificar las propiedades privadas
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }

    // --- CRUD (Create, Read, Update, Delete) ---

    // CREATE → Inserta un nuevo usuario en la base de datos
    public function agregar() {
        // Obtenemos conexión PDO
        $pdo = Conexion::conectar();

        // Preparamos la sentencia SQL con parámetros nombrados (más seguro)
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");

        // Ejecutamos la consulta enviando los valores del objeto
        $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':password' => $this->password
        ]);
    }

    // READ → Obtiene todos los usuarios de la tabla
    public static function listar() {
        // Conexión a la base de datos
        $pdo = Conexion::conectar();

        // Ejecutamos directamente la consulta porque no hay parámetros
        $stmt = $pdo->query("SELECT * FROM usuarios");

        // Devolvemos todos los registros como array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ (uno solo) → Obtiene un usuario por su ID
    public static function obtener($id) {
        $pdo = Conexion::conectar();

        // Preparamos consulta para evitar inyección SQL
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");

        // Ejecutamos pasando el id
        $stmt->execute([':id' => $id]);

        // Devolvemos el registro encontrado (o false si no existe)
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE → Actualiza un usuario según su ID
    public function actualizar($id) {
        $pdo = Conexion::conectar();

        // Consulta SQL con parámetros
        $stmt = $pdo->prepare("
            UPDATE usuarios 
            SET nombre = :nombre, email = :email, password = :password 
            WHERE id = :id
        ");

        // Ejecutamos enviando los datos actualizados
        $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':password' => $this->password,
            ':id' => $id
        ]);
    }

    // DELETE → Elimina un usuario por ID
    public static function eliminar($id) {
        $pdo = Conexion::conectar();

        // Consulta SQL preparada
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");

        // Ejecutamos enviando el ID
        $stmt->execute([':id' => $id]);
    }
}
?>
