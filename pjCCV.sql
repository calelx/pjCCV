create database pjCCV;

use pjCCV;

/*
	Para evitar errores a la conexion a la base de datos
	crear un user con:
	UserName: pjCCV
	Pasword: pjCCV
	Database: pjCCV
*/


create table tiposEventos (
	idTipo int,
	nombre char(100),
	frecuencia char(25),
	primary key (idTipo)
);

create table eventos (
	idEvento int, 
	idTipo int, 
	fecha date, 
	hora time, 
	titulo char(90),
	descripcion text,
	primary key (idEvento),
	foreign key (idTipo) references tiposEventos
);

create table contactos (
	Email char(100), 
	telefono char(9), 
	fechaNac date, 
	direccion char(150), 
	nombre char(100)
	primary key (Email)
);

create table cumple (
	idEvento int,
	Email char(100)
	foreign key (idEvento) references eventos,
	foreign key (Email) references contactos
);

insert into tiposEventos (idTipo, nombre, frecuencia) values (1, 'Cumple', 'yearly');

--Ver todos los datos de la tabla
select * from eventos;
select * from tiposEventos;
select * from contactos;
select * from cumple;

--Debugin de consultas importantes
SELECT COALESCE(MIN(t1.idEvento) + 1, 1) AS next_id FROM eventos t1 LEFT JOIN eventos t2 ON t1.idEvento + 1 = t2.idEvento WHERE t2.idEvento IS NULL;
SELECT ISNULL(MAX(idTipo), 0) + 1 AS next_id FROM tiposEventos;
