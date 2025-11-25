

<?php

    require_once __DIR__ . '/../config/database.php';

    class conexion{

        private static $pdo = null;

        public static function conectar(){
            if(self::$pdo === null){

                try{
                    self::$pdo = new PDO(
                        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHAR,
                        DB_USER,
                        DB_PASS,
                        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                    );

                }catch(PDOException $e){

                    die("Error de conexion: " . $e->getMessage());

                }
            }
            return self::$pdo;
        }
    }