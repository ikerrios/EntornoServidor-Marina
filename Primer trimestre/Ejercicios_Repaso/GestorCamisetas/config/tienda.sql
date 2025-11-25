create database tienda;

use tienda;

create table pedidos (
    id int primary key auto_increment not null,
    nombreCliente varchar(255) not null,
    equipo varchar(255) not null,
    talla varchar(5) not null,
    cantidad int not null,
    estadoPedido varchar(15) not null
);