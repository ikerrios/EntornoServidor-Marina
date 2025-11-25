<?php
class PerroController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_perro'])) {
            $p = new Perro($_POST['nombre'], $_POST['edad'], $_POST['raza']);
            $p->agregar();
            header("Location: index.php");
            exit;
        }

        // Redirigimos al controlador principal para que muestre todo
        header("Location: index.php");
    }
}