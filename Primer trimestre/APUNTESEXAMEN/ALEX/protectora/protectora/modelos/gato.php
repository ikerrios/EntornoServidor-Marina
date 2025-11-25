<?php
require_once "animal.php";

class Gato extends Animal {
    private $color;

    public function __construct($nombre, $edad, $color) {
        parent::__construct($nombre, $edad, "gato");
        $this->color = $color;
    }

    public function agregar() {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO animales (nombre, edad, tipo, color) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->nombre, $this->edad, $this->tipo, $this->color]);
    }

    public static function listar() {
        $pdo = Conexion::conectar();
        return $pdo->query("SELECT * FROM animales WHERE tipo='gato'")->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>