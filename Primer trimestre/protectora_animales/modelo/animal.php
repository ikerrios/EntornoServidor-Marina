<?php
require_once "conexion.php";

class Animal {
    // Propiedades privadas, encapsulamiento.
    protected $nombre;
    protected $edad;
    protected $tipo;

    // Constructor: se ejecuta al crear un objeto Usuario.
    // Recibe matricula, modelo y velocidad y los asigna al objeto.
    public function __construct($nombre, $edad, $tipo) {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->tipo = $tipo;
    }

    // --- Geters ---
    // Métodos que permiten obtener el valor de una propiedad privada.
    public function getNombre(){
        return $this->nombre;
    }
    
    public function getEdad() {
        return $this->edad;
    }

    public function getTipo() {
        return $this->tipo;
    }

    // --- Setters ---
    // Métodos para modificar las propiedades privadas.
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setEdad($edad) {
        $this->edad = $edad;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function agregar() {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO animales (nombre, edad, tipo) VALUES (?, ?, ?)");
        $stmt->execute([$this->nombre, $this->edad, $this->tipo]);
    }

    public static function listar() {
        $pdo = Conexion::conectar();
        return $pdo->query("SELECT * FROM animales")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function eliminar($id) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("DELETE FROM animales WHERE id=?");
        $stmt->execute([$id]);
    }
}
?>