<?php

require_once("animal.php");

class protectora {
    private $protectora = [];

    public function __construct() {

    }

    public function agregar() {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO animales (nombre, edad, tipo) VALUES (?, ?, ?)");
        $stmt->execute([$this->nombre, $this->edad, $this->tipo]);
    }
}


?>