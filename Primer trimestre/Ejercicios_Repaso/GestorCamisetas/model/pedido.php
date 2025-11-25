<?php

require_once("conexion.php");

class Pedido {
    protected $id;
    protected $nombreCliente;
    protected $equipo;
    protected $talla;
    protected $cantidad;
    protected $estadoPedido;

    public function __construct($id, $nombreCliente, $equipo, $talla, $cantidad) {
        $this -> id = $id;
        $this -> nombreCliente = $nombreCliente;
        $this -> equipo = $equipo;
        $this -> talla = $talla;
        $this -> cantidad = $cantidad;
        $this -> estadoPedido = "pendiente";
    }
    
    public function getId(){return $this->id;}
    public function getNombreCliente(){return $this->nombreCliente;}
    public function getEquipo(){return $this->equipo;}
    public function getTalla(){return $this->talla;}
    public function getCantidad(){return $this->cantidad;}
    public function getEstadoPedido(){return $this->estadoPedido;}

    public function setId($id){return $this->id=$id;}
    public function setNombreCliente($nombreCliente){return $this->nombreCliente=$nombreCliente;}
    public function setEquipo($equipo){return $this->equipo=$equipo;}
    public function setTalla($talla){return $this->talla=$talla;}
    public function setCantidad($cantidad){return $this->cantidad=$cantidad;}
    public function setEstadoPedido($estadoPedido){return $this->estadoPedido=$estadoPedido;}

    public function agregar() {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO tienda (nombreCliente, equipo, talla, cantidad) VALUES (?,?,?,?)");
        $stmt->execute([$this->nombreCliente, $this->equipo, $this->talla, $this->cantidad]);
    }

    public function listar() {
        $pdo = Conexion::conectar();
        return $pdo->query("SELECT * FROM tienda")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($id) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("DELETE FROM tienda WHERE id=?");
        $stmt->execute([$id]);
    }
}
?>