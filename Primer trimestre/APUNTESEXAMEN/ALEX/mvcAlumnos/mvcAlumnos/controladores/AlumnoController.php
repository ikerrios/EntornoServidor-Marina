<?php
    require_once __DIR__ . '/../modelos/conexion.php';
    require_once __DIR__ . '/../modelos/Alumno.php';
    

    class AlumnoController{

        private $admin_user = "admin";
        private $admin_pass = "1234";

        private $logueado = false;

        public function __construct(){

            //session_start();
            $this->comprobarLogin();
        }

        private function comprobarLogin(){
            
            if(isset($_GET['login'])){
                $_SESSION['logueado'] = false;
                setcookie('logueado', '1', time() + 3600 * 24); // 1 dia

                header("Location: index.php");
                exit;
            }


            if(isset($_GET['logout'])){

                session_destroy();
                setcookie('logueado', '', time() - 3600);
                header("Location: index.php");

                exit;
            }
            // comprobar si esta logueado
            $this->logueado = isset($_SESSION['logueado']) || isset($_COOKIE['logueado']);
        }

        public function index(){

            //eliminar

            if(isset($_GET['eliminar']) && $this->logueado){

                Alumno::eliminar($_GET['eliminar']);
                header("Location: index.php");
                exit;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST' && $this->logueado){

                $alumno = new Alumno(
                    $_POST['nombre'],
                    $_POST['email'],
                    $_POST['fecha_nacimiento'],
                    $_FILES['foto'] ?? null
                );

                $alumno->guardar();
                header("Location: index.php");
                exit;
            }

            $alumnos = Alumno::todos();
            $logueado = $this->logueado;
            require_once __DIR__ . '/../vistas/home.php';
            
        }
    }
    $controller = new AlumnoController();
    $controller->index();