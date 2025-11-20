<?php
class Conexion {
    public static function conectar() {
        return new PDO("mysql:host=localhost;dbname=protectora;charset=utf8", "root", "root");
    }
}
?>