create database tapa;

use tapa;

create table libro (
    id int primary key auto_increment,
    ISBN int,
    titulo varchar(255),
    genero varchar(255),
    editorial varchar(255),
    descripcion varchar(255),
    imagen varchar(255)

);
INSERT INTO libro (ISBN, titulo, genero, editorial, descripcion, imagen) VALUES
(97801, 'El Principito', 'Fábula', 'salamandra', 'Un clásico sobre la amistad y la vida.', 'imagenes/principito.jpg'),
(76104, 'El Código Da Vinci', 'Suspenso', 'planeta', 'Novela de misterio y conspiraciones.', 'imagenes/vinci.jpg'),
(35923, '1984', 'Distopía', 'edaf', 'Una visión crítica de un futuro totalitario.', 'imagenes/1984.jpg');