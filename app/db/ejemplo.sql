
select  ventas.id, ventas.fecha,ventas.idCripto, ventas.foto ,ventas.cantidad from criptos INNER JOIN ventas ON ventas.idCripto = criptos.id where criptos.nacionalidad='argentina' AND ventas.fecha > '2020-06-01' and ventas.fecha < '2025-02-01'



-- logs (id_usuario, id_arma, accion, fecha_accion) 
create table logs(
id int primary key AUTO_INCREMENT not null,
id_usuario int not null,
id_arma int not null,
accion varchar(50) not null,
fecha_accion date not null);

create table usuario_guerra(
id int primary key AUTO_INCREMENT not null,
mail varchar(50) not null,
clave varchar(50) not null,
tipo varchar(50) not null);

-- //id, precio,nombre, foto ,nacionalidad,fechaBaja
create table armamentos(
id int primary key AUTO_INCREMENT not null,
nombre varchar(50) not null,
foto varchar(50) not null,
nacionalidad varchar(50) not null,
fechaBaja date not null,
precio float not null);

create table productospedidos(
id int primary key AUTO_INCREMENT not null,
numeroPedido int not null,
idProducto int not null,
cantidad int not null,
estado varchar(50) not null);

create table pedidos(
id int primary key AUTO_INCREMENT not null,
codigoMesa int not null,
idUsuario int not null,
demoraPedido int  null,
estado varchar(50) not null,
precioPedido float  null,
foto varchar(50) not null)
 AUTO_INCREMENT = 10000;

create table mesas(
id int primary key AUTO_INCREMENT not null,
numeroMesa int not null,
estado varchar(50) not null,
nombreCliente varchar(50) not null);


--Creo tablas
create table usuario(
id int(10) PRIMARY KEY AUTO_INCREMENT not null,
nombre varchar(50) not null,
apellido varchar(50) not null,
clave varchar(50) not null,
mail varchar(50) not null,
fecha_de_registro date not null,
localidad varchar(50) not null);

create table producto(
id int primary key AUTO_INCREMENT not null,
codigo_de_barra int not null,
nombre varchar(50) not null,
tipo varchar(50) not null,
stock int not null,
precio float not null,
fecha_de_creacion date not null,
fecha_de_modificacion date not null);

create table venta (
id_producto int not null,
id_usuario int not null,
cantidad int not null,
fecha_de_venta date not null);


--Inserto datos en la tabla usuarios
insert into usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad) VALUES
('Esteban','Madou','2345','dkantor0@example.com','2021-07-01','Quilmes'),
('German','Gerram','1234','ggerram1@hud.gov','2020-08-05','Berazategui'),
('Deloris','Fosis','5678','bsharpe2@wisc.edu','2020-11-28','Avellaneda'),
('Brok','Neiner','4567','bblazic3@desdev.cn','2020-08-12','Quilmes'),
('Garrick','Brent','6789','gbrent4@theguardian.com','2020-12-17','Moron'),
('Biliu','Baus','0123','bhoff5@addthis.com','2020-11-27','Moreno');

--Modifico error en mi cargado de datos donde no setee el id donde correspondia comenzar
UPDATE usuario SET id = 101 WHERE usuario.id = 1;
UPDATE usuario SET id = 102 WHERE usuario.id = 2;
UPDATE usuario SET id = 103 WHERE usuario.id = 3;
UPDATE usuario SET id = 104 WHERE usuario.id = 4;
UPDATE usuario SET id = 105 WHERE usuario.id = 5;
UPDATE usuario SET id = 106 WHERE usuario.id = 6;


--Inserto datos en la tabla productos
insert into producto (id,codigo_de_barra,nombre,tipo,stock,precio,fecha_de_creacion,fecha_de_modificacion) values
(1001,77900361, 'Westmcptt','liquido',33,15.87,'2021-02-09','2020-09-26');
insert into producto (codigo_de_barra,nombre,tipo,stock,precio,fecha_de_creacion,fecha_de_modificacion) values
(77900362, 'Spirit', 'solido', 45, 69.74, '2020-09-18', '2020-04-14'),
(77900363, 'Newgrosh', 'polvo', 14, 68.19, '2020-11-29', '2021-02-11'),
(77900364, 'McNickle', 'polvo', 19, 53.51, '2020-11-28', '2020-04-17'),
(77900365, 'Hudd', 'solido', 68, 26.56, '2020-12-19',' 2020-06-19'),
(77900366, 'Schrader', 'polvo', 17, 96.54, '2020-08-02', '2020-04-18'),
(77900367, 'Bachellier', 'solido', 59, 69.17, '2021-01-30', '2020-06-07'),
(77900368, 'Fleming', 'solido', 38, 66.77, '2020-10-26', '2020-10-03'),
(77900369, 'Hurry', 'solido', 44, 43.01, '2020-07-04', '2020-05-30'),
(77900310, 'Krauss', 'polvo', 73, 35.73, '2021-03-03', '2020-08-30');

--Corrigo error de tipeo
update producto set nombre='Westmacott' WHERE id=1001


--Inseto datos en la tabla de ventas
insert into ventas (id_producto,id_usuario,cantidad,fecha_de_venta) values
(1001, 101, 2, '2020-07-19'),
(1008, 102, 3, '2020-08-16'),
(1007, 102, 4, '2021-01-24'),
(1006, 103, 5, '2021-01-14'),
(1003, 104, 6, '2021-03-20'),
(1005, 105, 7, '2021-02-22'),
(1003, 104, 6, '2020-12-02'),
(1003, 106, 6, '2020-06-10'),
(1002, 106, 6, '2021-02-04'),
(1001, 106, 1, '2020-05-17');


--CONSULTAS:

--1. Obtener los detalles completos de todos los usuarios, ordenados alfabéticamente.
select * from usuario order by nombre asc;
--2. Obtener los detalles completos de todos los productos líquidos.
select * from producto where tipo = 'liquido';
--3. Obtener todas las compras en los cuales la cantidad esté entre 6 y 10 inclusive.
select * from venta where cantidad between 6 and 10;
--4. Obtener la cantidad total de todos los productos vendidos.
select sum(cantidad) as cantidad_total_productos_vendidos from venta
--5. Mostrar los primeros 3 números de productos que se han enviado.
select codigo_de_barra from producto limit 3;
--6. Mostrar los nombres del usuario y los nombres de los productos de cada venta.
select usuario.nombre, producto.nombre from venta 
inner join usuario on venta.id_usuario=usuario.id
inner join producto on venta.id_producto=producto.id;
--7. Indicar el monto (cantidad * precio) por cada una de las venta.
select (venta.cantidad * producto.precio) as 'importe' from venta 
inner join producto on venta.id_producto=producto.id;
--8. Obtener la cantidad total del producto 1003 vendido por el usuario 104.
select venta.cantidad from venta
inner join usuario on venta.id_usuario=usuario.id
inner join producto on venta.id_producto=producto.id 
where producto.id=1003 and usuario.id=104;
--9. Obtener todos los números de los productos vendidos por algún usuario de ‘Avellaneda’.
select producto.codigo_de_barra, producto.id as id_producto, usuario.id as id_usuario from producto 
inner join venta on venta.id_producto=producto.id
inner join usuario on venta.id_usuario=usuario.id
where usuario.localidad = 'Avellaneda';
--10.Obtener los datos completos de los usuarios cuyos nombres contengan la letra ‘u’.
select * from usuario where nombre like '%u%'
--11. Traer las venta entre junio del 2020 y febrero 2021.
select producto.nombre, venta.fecha_de_venta from producto 
inner join venta on venta.id_producto=producto.id
where venta.fecha_de_venta > '2020-06-01' and venta.fecha_de_venta < '2021-02-01';
--12. Obtener los usuarios registrados antes del 2021.
select * from usuario WHERE fecha_de_registro < '2021-01-01';
--13.Agregar el producto llamado ‘Chocolate’, de tipo Sólido y con un precio de 25,35.
insert into producto (codigo_de_barra,nombre,tipo,stock,precio,fecha_de_creacion,fecha_de_modificacion)
values (12345678,'Chocolate','solido',1,25.35,'2022-09-20','2022-09-20');
--14.Insertar un nuevo usuario .
insert into usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)
values ('Don','Gato','1121','bigote@gmail.com','2022-09-20','Avellaneda');
--15.Cambiar los precios de los productos de tipo sólido a 66,60.
update producto set precio=66.60 where producto.tipo='solido';
--16.Cambiar el stock a 0 de todos los productos cuyas cantidades de stock sean menoresa 20 inclusive.
update producto set stock=0 where stock<=20;
--17.Eliminar el producto número 1010. --no usar delete todavia:
delete * from producto where id=1010;
--18.Eliminar a todos los usuarios que no han vendido productos.
--inserto previamente una venta nueva donde no haya productos vendidos para poder visualizar:
insert into venta (id_producto,id_usuario,cantidad,fecha_de_venta) values (1011,107,0,'');
--deleteo ese usuario
delete * from usuario
inner join venta on venta.id_usuario=usuario.id
where venta.cantidad = 0;
