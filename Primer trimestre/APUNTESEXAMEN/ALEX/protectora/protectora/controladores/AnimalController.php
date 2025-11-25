<?php
class AnimalController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['crear_animal'])) {
                $a = new Animal($_POST['nombre'], $_POST['edad'], $_POST['tipo'] ?? 'animal');
                $a->agregar();
                header("Location: index.php"); // redirige para evitar reenvío
                exit;
            }
        }

        if (isset($_GET['eliminar'])) {
            Animal::eliminar($_GET['eliminar']);
            header("Location: index.php");
            exit;
        }

        $animales = Animal::listar();
        $perros   = Perro::listar();
        $gatos    = Gato::listar();

        require "vistas/home.php";
    }
}