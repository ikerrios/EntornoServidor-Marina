<?php
require_once "animal.php";

class Perro extends Animal {
    private $raza;

    public function __construct($nombre, $edad, $raza) {
        parent::__construct($nombre, $edad, "perro");
        $this->raza = $raza;
    }

    public function agregar() {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO animales (nombre, edad, tipo, raza) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->nombre, $this->edad, $this->tipo, $this->raza]);
    }

    public static function listar() {
        $pdo = Conexion::conectar();
        return $pdo->query("SELECT * FROM animales WHERE tipo='perro'")->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>