<?php
require_once "conexion.php";

class Animal {
    protected $nombre;
    protected $edad;
    protected $tipo;

    public function __construct($nombre, $edad, $tipo) {
        $this->nombre = $nombre;
        $this->edad = $edad;
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