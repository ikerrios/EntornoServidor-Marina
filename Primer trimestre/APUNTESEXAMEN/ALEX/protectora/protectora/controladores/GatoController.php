<?php
class GatoController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_gato'])) {
            $g = new Gato($_POST['nombre'], $_POST['edad'], $_POST['color']);
            $g->agregar();
            header("Location: index.php");
            exit;
        }

        header("Location: index.php");
    }
}