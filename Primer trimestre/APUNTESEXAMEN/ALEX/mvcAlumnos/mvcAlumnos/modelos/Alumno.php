<?php

    require_once 'conexion.php';


    class Alumno{
        
        private $id;
        private $nombre;
        private $email;
        private $fecha_nacimiento;
        private $foto;

        public function __construct($nombre,$email, $fecha_nacimiento,$foto = null, $id=null) {

            $this->nombre = $nombre;
            $this->email = $email;
            $this->fecha_nacimiento = $fecha_nacimiento;
            $this->foto = $foto;
            $this->id = $id;

        }


        //Guarda el create y la foto
        public function guardar(){
            // Crear carpeta uploads si no existe
            if (!is_dir("../uploads")) {
                mkdir("../uploads", 0777, true);
            }
            $pdo = conexion::conectar();
            $nombreFoto = null;

            if ($this->foto && $this->foto['error'] === UPLOAD_ERR_OK) {
                $nombreFoto = time() . "_" . basename($this->foto['name']);
                // Ruta ABSOLUTA a la carpeta uploads (nunca falla)
                $ruta = __DIR__ . '/../uploads/' . $nombreFoto;
                move_uploaded_file($this->foto['tmp_name'], $ruta);
            }

            $sql = "INSERT INTO alumnos (nombre, email, fecha_nacimiento, foto) VALUES (?,?,?,?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([$this->nombre,$this->email,$this->fecha_nacimiento,$nombreFoto]);
        }


        // Listar a todos

        public static function todos(){

            $pdo = conexion::conectar();

            $stmt = $pdo->prepare("SELECT * FROM alumnos ORDER BY nombre");
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Buscar por id
        public static function buscar($id){

            $pdo = conexion::conectar();

            $stmt = $pdo->prepare("SELECT * FROM alumnos WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Actualizar datos alum

        public static function actualizar($id,$datos,$foto=null){

            $pdo = conexion::conectar();
            $nombreFoto = null;

            if($foto && $foto['error'] === 0){

                $nombreFoto = time() . "_" . basename($foto['name']);
                move_uploaded_file($foto['tmp_name'], "../uploads/" . $nombreFoto);

            }

            $sql = "UPDATE alumnos SET nombre = ?, email = ?, fecha_nacimiento = ? " .
                    ($nombreFoto ? ", foto = ?" : "") . " WHERE id = ?";

            $params = [$datos['nombre'], $datos['email'], $datos['fecha_nacimiento']];

            if($nombreFoto) $params[] = $nombreFoto;
            $params[] = $id;

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
        }


        // Eliminar alum

        public static function eliminar($id)  {

            $pdo = conexion::conectar();

            $stmt = $pdo->prepare("DELETE FROM alumnos WHERE id = ?");

            $stmt->execute([$id]);
            
        }
    }