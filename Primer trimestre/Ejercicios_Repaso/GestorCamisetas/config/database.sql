create database gestorCamisetas;

use gestorCamisetas;

create table camiseta (
    id int primary key auto_increment not null,
    nombre_cliente varchar(30) not null,
    telefono int not null,
    equipo varchar(30) not null,
    talla varchar(5) not null,
    cantidad int not null,
    estado varchar (15) not null,
    fecha_pedido date not null
);
