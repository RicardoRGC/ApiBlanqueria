//2-(POST)Alta cripto moneda( precio, nombre, foto, nacionalidad)->solo admin/(JWT)

create table criptos(
id int primary key AUTO_INCREMENT not null,
precio float not null,
nombre varchar(50) not null,
foto varchar(50) not null,
nacionalidad varchar(50) not null);

create table ventas(
id int primary key AUTO_INCREMENT not null,
fecha date not null,
idCripto int not null,
cantidad int not null,
nombreUsuario varchar(50) not null,
estado varchar(50) not null);